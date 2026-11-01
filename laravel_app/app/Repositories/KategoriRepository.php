<?php

namespace App\Repositories;

use App\Models\Model_Kategori;
use App\Repositories\Interfaces\IKategoriRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class KategoriRepository implements IKategoriRepository
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Model_Kategori::latest()->paginate($perPage);
    }

    public function allOrdered(): Collection
    {
        return Model_Kategori::orderBy('nama_kategori')->get();
    }

    public function create(array $attributes): Model_Kategori
    {
        return Model_Kategori::create($attributes);
    }

    public function update(Model_Kategori $kategori, array $attributes): Model_Kategori
    {
        $kategori->update($attributes);

        return $kategori->refresh();
    }

    public function delete(Model_Kategori $kategori): void
    {
        $kategori->delete();
    }
}
