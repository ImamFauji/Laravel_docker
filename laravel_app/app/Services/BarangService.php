<?php

namespace App\Services;

use App\Models\Model_Barang;
use App\Repositories\Interfaces\IBarangRepository;
use App\Services\Interfaces\IBarangService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BarangService implements IBarangService
{
    public function __construct(
        private readonly IBarangRepository $barangRepository,
    ) {
    }

    public function create(array $attributes, ?UploadedFile $picture = null): Model_Barang
    {
        unset($attributes['picture']);

        if ($picture !== null) {
            $attributes['gambar'] = $picture->store('barang', 'public');
        }

        return $this->barangRepository->create($attributes);
    }

    public function update(
        Model_Barang $barang,
        array $attributes,
        ?UploadedFile $picture = null,
    ): Model_Barang {
        unset($attributes['picture']);

        if ($picture !== null) {
            $this->deletePicture($barang);
            $attributes['gambar'] = $picture->store('barang', 'public');
        }

        return $this->barangRepository->update($barang, $attributes);
    }

    public function delete(Model_Barang $barang): void
    {
        $this->deletePicture($barang);
        $this->barangRepository->delete($barang);
    }

    private function deletePicture(Model_Barang $barang): void
    {
        if ($barang->gambar !== null && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }
    }
}
