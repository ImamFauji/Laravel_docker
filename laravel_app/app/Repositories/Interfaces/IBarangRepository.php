<?php

namespace App\Repositories\Interfaces;

use App\Models\Model_Barang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IBarangRepository
{
    public function paginate(array $filters, int $perPage = 10): LengthAwarePaginator;

    public function create(array $attributes): Model_Barang;

    public function update(Model_Barang $barang, array $attributes): Model_Barang;

    public function delete(Model_Barang $barang): void;
}
