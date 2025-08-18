<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Model_Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Model_Kategori::updateOrCreate(['id' => 1], ['nama_kategori' => 'Laptop']);
        Model_Kategori::updateOrCreate(['id' => 2], ['nama_kategori' => 'Monitor']);
        Model_Kategori::updateOrCreate(['id' => 3], ['nama_kategori' => 'Gear/Accessories']);
        Model_Kategori::updateOrCreate(['id' => 4], ['nama_kategori' => 'VGA Card']);
        Model_Kategori::updateOrCreate(['id' => 5], ['nama_kategori' => 'Elektronik']);
        Model_Kategori::updateOrCreate(['id' => 6], ['nama_kategori' => 'Handphone']);
        Model_Kategori::updateOrCreate(['id' => 7], ['nama_kategori' => 'Smartphone']);
        Model_Kategori::updateOrCreate(['id' => 8], ['nama_kategori' => 'Tablet']);
        Model_Kategori::updateOrCreate(['id' => 9], ['nama_kategori' => 'Processor Desktop/Laptop']);
        Model_Kategori::updateOrCreate(['id' => 10], ['nama_kategori' => 'RAM Desktop/Laptop']);
    }
}
