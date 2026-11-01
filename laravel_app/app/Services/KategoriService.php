<?php

namespace App\Services;

use App\Models\Model_Kategori;
use App\Repositories\Interfaces\IKategoriRepository;
use App\Services\Interfaces\IKategoriService;

class KategoriService implements IKategoriService
{
    public function __construct(
        private readonly IKategoriRepository $kategoriRepository,
    ) {
    }

    public function create(array $attributes): Model_Kategori
    {
        return $this->kategoriRepository->create($attributes);
    }

    public function update(Model_Kategori $kategori, array $attributes): Model_Kategori
    {
        return $this->kategoriRepository->update($kategori, $attributes);
    }

    public function delete(Model_Kategori $kategori): void
    {
        $this->kategoriRepository->delete($kategori);
    }
}
