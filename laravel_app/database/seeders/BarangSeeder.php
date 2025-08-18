<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Model_Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // Sample Barang 1
        Model_Barang::create([
            'nama' => 'Lenovo ThinkPad X250	',
            'kode_barang' => 'BRG001',
            'kategori_id' => 1, // pastikan kategori dengan ID 1 ada
            'jumlah_stock' => 8,
            'lokasi' => 'Gudang A',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 2
        Model_Barang::create([
            'nama' => 'Monitor Samsung 24 inch',
            'kode_barang' => 'BRG002',
            'kategori_id' => 2, // pastikan kategori dengan ID 2 ada
            'jumlah_stock' => 5,
            'lokasi' => 'Gudang B',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 3
        Model_Barang::create([
            'nama' => 'Monitor AOC 24 inch',
            'kode_barang' => 'BRG003',
            'kategori_id' => 3, // pastikan kategori dengan ID 3 ada
            'jumlah_stock' => 4,
            'lokasi' => 'Gudang B',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 4
        Model_Barang::create([
            'nama' => 'Microsoft Surface Book 2',
            'kode_barang' => 'BRG004',
            'kategori_id' => 4, // pastikan kategori dengan ID 4 ada
            'jumlah_stock' => 2,
            'lokasi' => 'Gudang A',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 5
        Model_Barang::create([
            'nama' => 'Asus Rog GL552V 15.6 inch',
            'kode_barang' => 'BRG005',
            'kategori_id' => 5, // pastikan kategori dengan ID 5 ada
            'jumlah_stock' => 1,
            'lokasi' => 'Gudang A',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 6
        Model_Barang::create([
            'nama' => 'Monitor LG 29WK600 Ultrawide',
            'kode_barang' => 'BRG006',
            'kategori_id' => 6, // pastikan kategori dengan ID 6 ada
            'jumlah_stock' => 2,
            'lokasi' => 'Gudang B',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 7
        Model_Barang::create([
            'nama' => 'Monitor Xiaomi 27 inch',
            'kode_barang' => 'BRG007',
            'kategori_id' => 7, // pastikan kategori dengan ID 7 ada
            'jumlah_stock' => 7,
            'lokasi' => 'Gudang B',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 8
        Model_Barang::create([
            'nama' => 'Mouse Gaming Logitech G102',
            'kode_barang' => 'BRG008',
            'kategori_id' => 8, // pastikan kategori dengan ID 8 ada
            'jumlah_stock' => 5,
            'lokasi' => 'Gudang C',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 9
        Model_Barang::create([
            'nama' => 'Keyboard Gaming Royal Kludge RK68',
            'kode_barang' => 'BRG009',
            'kategori_id' => 9, // pastikan kategori dengan ID 9 ada
            'jumlah_stock' => 5,
            'lokasi' => 'Gudang C',
            'tanggal_kategori' => '2025-08-18',
        ]);

        // Sample Barang 10
        Model_Barang::create([
            'nama' => 'Headset Steelseries Arctis 7',
            'kode_barang' => 'BRG010',
            'kategori_id' => 10, // pastikan kategori dengan ID 10 ada
            'jumlah_stock' => 3,
            'lokasi' => 'Gudang C',
            'tanggal_kategori' => '2025-08-18',
        ]);
    }
}
