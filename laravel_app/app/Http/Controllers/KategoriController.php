<?php

namespace App\Http\Controllers;

use App\Models\Model_Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index() {
        $kategori = Model_Kategori::latest()->paginate(10);
        return view('kategori.index', compact('kategori'));
    }

    public function create() {
        return view('kategori.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori|max:255',
        ]);
        Model_Kategori::create($validated);
        return redirect()->route('kategori.index')->with('success','Kategori dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(Model_Kategori $kategori) {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Model_Kategori $kategori) {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,'.$kategori->id.'|max:255',
        ]);
        $kategori->update($validated);
        return redirect()->route('kategori.index')->with('success','Kategori diperbarui.');
    }

    public function destroy(Model_Kategori $kategori) {
        $kategori->delete();
        return back()->with('success','Kategori dihapus.');
    }
}
