<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        /** --------------------------
         * 1️⃣  SEED USER + COURIER
         * -------------------------- */
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Kurir ' . $i,
                'email' => 'kurir' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'courier',
            ]);

            Courier::create([
                'user_id' => $user->id,
                'phone_number' => '08' . fake()->numerify('##########'),
            ]);
        }

        /** --------------------------
         * 2️⃣  SEED PRODUK & GUDANG
         * -------------------------- */
        // Kategori
        $categories = [
            ['category_name' => 'Kaos', 'description' => 'Berbagai jenis kaos polos dan sablon', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Kemeja', 'description' => 'Kemeja formal dan casual', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Jaket', 'description' => 'Jaket hoodie dan bomber', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('product_categories')->insert($categories);

        // Produk
        $products = [
            ['category_id' => 1, 'product_name' => 'Kaos Polos Cotton Combed 30s', 'stock' => 120, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 1, 'product_name' => 'Kaos Sablon Distro', 'stock' => 80, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 2, 'product_name' => 'Kemeja Flanel Pria', 'stock' => 45, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 2, 'product_name' => 'Kemeja Putih Kantor', 'stock' => 60, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 3, 'product_name' => 'Jaket Hoodie Oversize', 'stock' => 90, 'created_at' => $now, 'updated_at' => $now],
            ['category_id' => 3, 'product_name' => 'Jaket Bomber Pria', 'stock' => 50, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('products')->insert($products);

        // Variasi Produk
        $variants = [
            ['product_id' => 1, 'size' => 'S', 'stock' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 1, 'size' => 'M', 'stock' => 40, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 1, 'size' => 'L', 'stock' => 50, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 2, 'size' => 'M', 'stock' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 2, 'size' => 'L', 'stock' => 50, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 3, 'size' => 'M', 'stock' => 20, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 3, 'size' => 'L', 'stock' => 25, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 4, 'size' => 'S', 'stock' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 4, 'size' => 'M', 'stock' => 30, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 5, 'size' => 'L', 'stock' => 50, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 5, 'size' => 'XL', 'stock' => 40, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 6, 'size' => 'M', 'stock' => 20, 'created_at' => $now, 'updated_at' => $now],
            ['product_id' => 6, 'size' => 'L', 'stock' => 30, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('product_variants')->insert($variants);

        // Barang Keluar Gudang
        $clothesOut = [
            ['date_out' => '2025-10-01', 'product_variant_id' => 2, 'quantity_out' => 5, 'notes' => 'Pesanan pelanggan A', 'created_at' => $now, 'updated_at' => $now],
            ['date_out' => '2025-10-02', 'product_variant_id' => 4, 'quantity_out' => 3, 'notes' => 'Pesanan pelanggan B', 'created_at' => $now, 'updated_at' => $now],
            ['date_out' => '2025-10-03', 'product_variant_id' => 7, 'quantity_out' => 2, 'notes' => 'Penjualan langsung', 'created_at' => $now, 'updated_at' => $now],
            ['date_out' => '2025-10-04', 'product_variant_id' => 11, 'quantity_out' => 4, 'notes' => 'Pesanan reseller', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('clothes_out_warehouse')->insert($clothesOut);
    }
}
