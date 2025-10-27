<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\ClothesOutWarehouse;
use App\Models\ProductVariant;

class DashboardController extends Controller
{
    /**
     * 🏠 Tampilkan halaman dashboard utama
     */
    public function index()
    {
        return view('dashboard'); // pastikan file Blade = resources/views/dashboard.blade.php
    }

    /**
     * 🤖 Endpoint API untuk analisis Gemini
     */
    public function geminiApi()
    {
        // 1️⃣ Ambil data penjualan (pengeluaran barang dari gudang)
        $salesData = ClothesOutWarehouse::select('date_out', 'product_variant_id', 'quantity_out', 'notes')
            ->orderBy('date_out', 'desc')
            ->limit(10)
            ->get();

        // 2️⃣ Ambil data stok (join ke products untuk ambil nama produk)
        $stockData = ProductVariant::join('products', 'product_variants.product_id', '=', 'products.id')
            ->select(
                'product_variants.id as product_variant_id',
                'products.product_name',
                'product_variants.size',
                'product_variants.stock as stock_quantity'
            )
            ->get();

        // 3️⃣ Ubah ke JSON (karena Gemini membaca teks, bukan objek)
        $jsonSales = $salesData->toJson();
        $jsonStock = $stockData->toJson();

        // 4️⃣ Siapkan body untuk dikirim ke Gemini
        $body = [
            "contents" => [[
                "parts" => [
                    [
                        "text" => "
                        Kamu adalah asisten analisis gudang pakaian.
                        Berdasarkan dua data berikut ini, buat analisis lengkap:

                        1. Berdasarkan data penjualan terakhir, produk dan ukuran (size) apa yang paling laku.
                        2. Berdasarkan data stok saat ini, produk dan ukuran apa yang stoknya mulai menipis.
                        3. Berikan rekomendasi produk dan size apa yang harus segera diproduksi ulang beserta jumlah saran produksinya.
                        4. Sertakan alasan rekomendasi berdasarkan perbandingan antara penjualan dan stok.

                        Jawab dalam bahasa Indonesia yang rapi, tanpa tanda markdown (** atau *), dan tidak menggunakan bullet atau heading markdown.
                        "
                    ],
                    ["text" => "📦 Data Penjualan:\n" . $jsonSales],
                    ["text" => "🏷️ Data Stok Gudang:\n" . $jsonStock]
                ]
            ]]
        ];

        // 5️⃣ Kirim ke Gemini API (gunakan endpoint yang stabil)
        $url = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, $body);

        // 🔍 Jika gagal (misal API key salah / limit tercapai)
        if ($response->failed()) {
            return response()->json([
                'output' => '❌ Gagal memanggil Gemini API',
                'debug' => $response->body(),
            ], $response->status());
        }

        // 6️⃣ Ambil hasil dari Gemini
        $result = $response->json();
        $outputRaw = $result['candidates'][0]['content']['parts'][0]['text'] ?? '❌ Tidak ada hasil dari Gemini.';

        // 7️⃣ Hapus format markdown (**bold**, *italic*, `code`, #heading)
        $output = preg_replace([
            '/\*\*(.*?)\*\*/', // **bold**
            '/\*(.*?)\*/',     // *italic*
            '/`(.*?)`/',       // `inline code`
            '/#+\s?(.*)/',     // # Heading
        ], ['$1', '$1', '$1', '$1'], $outputRaw);

        // Hilangkan baris kosong ganda
        $output = preg_replace("/\n{2,}/", "\n\n", trim($output));

        return response()->json(['output' => $output]);
    }
}
