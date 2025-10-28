<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryToTailor;
use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{
    public function getRoute($id)
    {
        // Hardcode titik konveksi (misalnya konveksi di Bandung)
        $konveksiLat = -6.9402986363023;
        $konveksiLng = 107.57329502186651;

        $delivery = DeliveryToTailor::with('tailor')->findOrFail($id);

        if (!$delivery->tailor || !$delivery->tailor->latitude || !$delivery->tailor->longitude) {
            return response()->json(['error' => 'Koordinat penjahit tidak tersedia.'], 400);
        }

        $tailorLat = $delivery->tailor->latitude;
        $tailorLng = $delivery->tailor->longitude;

        // Format titik rute: antar → pulang → ambil → pulang
        $coordinates = [
            "$konveksiLng,$konveksiLat", // mulai dari konveksi
            "$tailorLng,$tailorLat",     // antar ke penjahit
            "$konveksiLng,$konveksiLat", // kembali ke konveksi
            "$tailorLng,$tailorLat",     // ambil hasil
            "$konveksiLng,$konveksiLat"  // kembali lagi ke konveksi
        ];

        $url = 'http://router.project-osrm.org/route/v1/driving/' . implode(';', $coordinates) . '?overview=full&geometries=geojson';

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json(['error' => 'Gagal mengambil rute dari OSRM'], 500);
        }

        $data = $response->json();

        return response()->json([
            'delivery_id' => $id,
            'courier' => $delivery->courier->user->name ?? '-',
            'tailor' => $delivery->tailor->name ?? '-',
            'status' => $delivery->status, // ← tambah status di sini
            'route' => $data['routes'][0] ?? null,
        ]);
    }
}
