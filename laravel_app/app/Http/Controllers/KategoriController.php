<?php

namespace App\Http\Controllers;

use App\Models\Model_Kategori;
use App\Repositories\Interfaces\IKategoriRepository;
use App\Services\Interfaces\IKategoriService;
use Illuminate\Http\Request;

class KategoriController
{
    public function __construct(
        private readonly IKategoriRepository $kategoriRepository,
        private readonly IKategoriService $kategoriService,
    ) {
    }

    public function index()
    {
        $kategori = $this->kategoriRepository->paginate();

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori|max:255',
        ]);

        $this->kategoriService->create($validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori dibuat.');
    }

    public function edit(Model_Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Model_Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $kategori->id . '|max:255',
        ]);

        $this->kategoriService->update($kategori, $validated);

        return redirect()->route('kategori.index')->with('success', 'Kategori diperbarui.');
    }

    public function destroy(Model_Kategori $kategori)
    {
        $this->kategoriService->delete($kategori);

        return back()->with('success', 'Kategori dihapus.');
    }
}
