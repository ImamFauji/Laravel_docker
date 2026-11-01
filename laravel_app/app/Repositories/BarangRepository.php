<?php

namespace App\Repositories;

use App\Repositories\Interfaces\IBarangRepository;
use App\Models\Model_Barang;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BarangRepository implements IBarangRepository
{
    public function paginate(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = Model_Barang::with('kategori');

        if (!empty($filters['search'])) {
            $query->where('nama', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['kategori_id'])) {
            $query->where('kategori_id', $filters['kategori_id']);
        }

        return $query->latest()->paginate($perPage)->appends($filters);
    }

    public function create(array $attributes): Model_Barang
    {
        return Model_Barang::create($attributes);
    }

    public function update(Model_Barang $barang, array $attributes): Model_Barang
    {
        $barang->update($attributes);

        return $barang->refresh();
    }

    public function delete(Model_Barang $barang): void
    {
        $barang->delete();
    }
}
