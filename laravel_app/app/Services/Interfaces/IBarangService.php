<?php

namespace App\Services\Interfaces;

use App\Models\Model_Barang;
use Illuminate\Http\UploadedFile;

interface IBarangService
{
    public function create(array $attributes, ?UploadedFile $picture = null): Model_Barang;

    public function update(
        Model_Barang $barang,
        array $attributes,
        ?UploadedFile $picture = null,
    ): Model_Barang;

    public function delete(Model_Barang $barang): void;
}
