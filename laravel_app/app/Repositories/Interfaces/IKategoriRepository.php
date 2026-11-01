<?php

namespace App\Repositories\Interfaces;

use App\Models\Model_Kategori;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IKategoriRepository
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function allOrdered(): Collection;

    public function create(array $attributes): Model_Kategori;

    public function update(Model_Kategori $kategori, array $attributes): Model_Kategori;

    public function delete(Model_Kategori $kategori): void;
}
