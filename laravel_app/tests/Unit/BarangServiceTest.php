<?php

namespace Tests\Unit;

use App\Models\Model_Barang;
use App\Repositories\Interfaces\IBarangRepository;
use App\Services\BarangService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class BarangServiceTest extends TestCase
{
    public function test_create_stores_picture_and_removes_upload_field(): void
    {
        Storage::fake('public');
        $repository = Mockery::mock(IBarangRepository::class);
        $repository->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function (array $attributes): bool {
                return isset($attributes['gambar'])
                    && !isset($attributes['picture']);
            }))
            ->andReturn(new Model_Barang());

        $picture = UploadedFile::fake()->image('laptop.jpg');
        (new BarangService($repository))->create(['nama' => 'Laptop', 'picture' => $picture], $picture);

        $this->assertCount(1, Storage::disk('public')->allFiles('barang'));
    }

    public function test_delete_removes_existing_picture_before_deleting_barang(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('barang/laptop.jpg', 'image');
        $repository = Mockery::mock(IBarangRepository::class);
        $repository->shouldReceive('delete')->once();
        $barang = new Model_Barang(['gambar' => 'barang/laptop.jpg']);

        (new BarangService($repository))->delete($barang);

        Storage::disk('public')->assertMissing('barang/laptop.jpg');
    }
}
