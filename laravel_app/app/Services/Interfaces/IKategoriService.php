<?php

namespace App\Services\Interfaces;

use App\Models\Model_Kategori;

interface IKategoriService
{
    public function create(array $attributes): Model_Kategori;

    public function update(Model_Kategori $kategori, array $attributes): Model_Kategori;

    public function delete(Model_Kategori $kategori): void;
}
