<?php

namespace Tests\Unit;

use App\Models\Model_Barang;
use App\Models\Model_Kategori;
use App\Repositories\BarangRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarangRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_filters_barang_by_search_and_category(): void
    {
        $laptop = Model_Kategori::create(['nama_kategori' => 'Laptop']);
        $monitor = Model_Kategori::create(['nama_kategori' => 'Monitor']);

        Model_Barang::create([
            'nama' => 'Laptop Lenovo',
            'kode_barang' => 'BRG-001',
            'kategori_id' => $laptop->id,
            'jumlah_stock' => 3,
            'lokasi' => 'Gudang A',
            'tanggal_kategori' => '2025-08-18',
        ]);
        Model_Barang::create([
            'nama' => 'Monitor Samsung',
            'kode_barang' => 'BRG-002',
            'kategori_id' => $monitor->id,
            'jumlah_stock' => 5,
            'lokasi' => 'Gudang B',
            'tanggal_kategori' => '2025-08-18',
        ]);

        $results = (new BarangRepository())->paginate([
            'search' => 'Lenovo',
            'kategori_id' => $laptop->id,
        ]);

        $this->assertSame(1, $results->total());
        $this->assertSame('Laptop Lenovo', $results->first()->nama);
        $this->assertTrue($results->first()->relationLoaded('kategori'));
    }

    public function test_it_creates_updates_and_deletes_barang(): void
    {
        $kategori = Model_Kategori::create(['nama_kategori' => 'Laptop']);
        $repository = new BarangRepository();
        $barang = $repository->create([
            'nama' => 'Laptop Lama',
            'kode_barang' => 'BRG-003',
            'kategori_id' => $kategori->id,
            'jumlah_stock' => 1,
            'lokasi' => 'Gudang A',
            'tanggal_kategori' => '2025-08-18',
        ]);

        $updated = $repository->update($barang, ['nama' => 'Laptop Baru']);

        $this->assertSame('Laptop Baru', $updated->nama);
        $repository->delete($updated);
        $this->assertDatabaseMissing('barang', ['id' => $barang->id]);
    }
}
