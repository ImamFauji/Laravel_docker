<?php

namespace Tests\Feature;

use App\Models\Model_Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_inventory_pages(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/barang')->assertRedirect('/login');
        $this->get('/kategori')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_and_filter_barang(): void
    {
        Storage::fake('public');
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $kategori = Model_Kategori::create(['nama_kategori' => 'Laptop']);

        $this->actingAs($user)
            ->post('/barang', [
                'kode_barang' => 'BRG-001',
                'nama' => 'Laptop Lenovo',
                'kategori_id' => $kategori->id,
                'jumlah_stock' => 4,
                'lokasi' => 'Gudang A',
                'tanggal_kategori' => '2025-08-18',
                'picture' => UploadedFile::fake()->image('laptop.jpg'),
            ])
            ->assertRedirect('/barang');

        $this->assertDatabaseHas('barang', [
            'kode_barang' => 'BRG-001',
            'nama' => 'Laptop Lenovo',
        ]);

        $this->actingAs($user)
            ->get('/barang?search=Lenovo&kategori_id=' . $kategori->id)
            ->assertOk()
            ->assertSee('Laptop Lenovo');
    }

    public function test_authenticated_user_can_manage_categories(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user)
            ->post('/kategori', ['nama_kategori' => 'Laptop'])
            ->assertRedirect('/kategori');

        $kategori = Model_Kategori::firstOrFail();
        $this->actingAs($user)
            ->put('/kategori/' . $kategori->id, ['nama_kategori' => 'Notebook'])
            ->assertRedirect('/kategori');

        $this->assertDatabaseHas('kategori', ['nama_kategori' => 'Notebook']);
        $this->actingAs($user)
            ->delete('/kategori/' . $kategori->id)
            ->assertRedirect();
        $this->assertDatabaseMissing('kategori', ['id' => $kategori->id]);
    }
}
