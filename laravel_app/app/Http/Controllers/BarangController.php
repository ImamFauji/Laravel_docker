<?php

namespace App\Http\Controllers;

use App\Models\Model_Barang;
use App\Repositories\Interfaces\IBarangRepository;
use App\Repositories\Interfaces\IKategoriRepository;
use App\Services\Interfaces\IBarangService;
use Illuminate\Http\Request;

class BarangController
{
    public function __construct(
        private readonly IBarangRepository $barangRepository,
        private readonly IKategoriRepository $kategoriRepository,
        private readonly IBarangService $barangService,
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'kategori_id']);
        $barang = $this->barangRepository->paginate($filters);
        $kategori = $this->kategoriRepository->allOrdered();

        return view('barang.index', compact('barang', 'kategori'));
    }

    public function create()
    {
        $kategori = $this->kategoriRepository->allOrdered();

        return view('barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang',
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'jumlah_stock' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
            'tanggal_kategori' => 'required|date',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->barangService->create($validated, $request->file('picture'));

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Model_Barang $barang)
    {
        $kategori = $this->kategoriRepository->allOrdered();

        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, Model_Barang $barang)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang,' . $barang->id,
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'jumlah_stock' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
            'tanggal_kategori' => 'required|date',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->barangService->update($barang, $validated, $request->file('picture'));

        return redirect()->route('barang.index')->with('success', 'Barang diperbarui.');
    }

    public function destroy(Model_Barang $barang)
    {
        $this->barangService->delete($barang);

        return back()->with('success', 'Barang dan gambar berhasil dihapus.');
    }
}
