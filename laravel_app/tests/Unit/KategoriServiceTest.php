<?php

namespace Tests\Unit;

use App\Models\Model_Kategori;
use App\Repositories\Interfaces\IKategoriRepository;
use App\Services\KategoriService;
use Mockery;
use Tests\TestCase;

class KategoriServiceTest extends TestCase
{
    public function test_create_delegates_to_repository(): void
    {
        $repository = Mockery::mock(IKategoriRepository::class);
        $repository->shouldReceive('create')
            ->once()
            ->with(['nama_kategori' => 'Laptop'])
            ->andReturn(new Model_Kategori(['nama_kategori' => 'Laptop']));

        $result = (new KategoriService($repository))->create(['nama_kategori' => 'Laptop']);

        $this->assertSame('Laptop', $result->nama_kategori);
    }
}
