<?php

namespace Tests\Unit;

use App\Models\Model_Kategori;
use App\Repositories\KategoriRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_categories_in_latest_order(): void
    {
        $first = Model_Kategori::create(['nama_kategori' => 'Laptop']);
        $second = Model_Kategori::create(['nama_kategori' => 'Monitor']);

        $results = (new KategoriRepository())->paginate();

        $this->assertSame(2, $results->total());
        $this->assertEqualsCanonicalizing(
            [$first->id, $second->id],
            $results->pluck('id')->all(),
        );
    }
}
