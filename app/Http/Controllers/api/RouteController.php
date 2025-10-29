<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeliveryToTailor;
use Illuminate\Support\Facades\Http;

class RouteController extends Controller
{

    public function getAllDeliveries()
    {
        $courier = auth('courier')->user(); // ✅ ambil dari guard courier

        if (!$courier) {
            return response()->json(['error' => 'Kurir belum login.'], 401);
        }

        $deliveries = DeliveryToTailor::with('tailor')
            ->where('courier_id', $courier->id)
            ->get(['id', 'tailor_id', 'status', 'delivery_date', 'due_date']);

        if ($deliveries->isEmpty()) {
            return response()->json(['message' => 'Tidak ada pengantaran untuk kurir ini.']);
        }

        $data = $deliveries->map(fn($d) => [
            'delivery_id' => $d->id,
            'tailor' => $d->tailor->name ?? '-',
            'status' => $d->status,
            'delivery_date' => $d->delivery_date,
            'due_date' => $d->due_date,
        ]);

        return response()->json([
            'courier' => $courier->name,
            'total_deliveries' => $data->count(),
            'deliveries' => $data,
        ]);
    }


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

        $url = 'http://router.project-osrm.org/route/v1/driving/' . implode(';', $coordinates) . '?overview=full&geometries=geojson&steps=true';

        $response = Http::get($url);

        if (!$response->successful()) {
            return response()->json(['error' => 'Gagal mengambil rute dari OSRM'], 500);
        }

        $data = $response->json();

        return response()->json([
            'delivery_id' => $id,
            'courier' => $delivery->courier->name ?? '-',
            'tailor' => $delivery->tailor->name ?? '-',
            'status' => $delivery->status, // ← tambah status di sini
            'route' => $data['routes'][0] ?? null,
        ]);
    }
}
