<?php

namespace App\Http\Controllers;

use App\Models\Model_Barang;
use App\Models\Model_Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Model_Barang::with('kategori');

        // Search berdasarkan nama barang
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $barang = $query->with('kategori')->paginate(10);
        $kategori = Model_Kategori::all();

        $barang = $query->latest()->paginate(10)->appends($request->query()); // pagination tetap simpan query
        $kategori = Model_Kategori::orderBy('nama_kategori')->get();

        return view('barang.index', compact('barang', 'kategori'));
    }

    public function create()
    {
        $kategori = Model_Kategori::orderBy('nama_kategori')->get();
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

        if ($request->hasFile('picture')) {
            // Simpan langsung ke folder public/barang (bukan per nama barang)
            $path = $request->file('picture')->store('barang', 'public');
            $validated['gambar'] = $path;
        }


        // if ($request->hasFile('picture')) {
        //     // buat nama file unik agar tidak bentrok
        //     $filename = time() . '_' . uniqid() . '.' . $request->file('picture')->getClientOriginalExtension();

        //     // simpan gambar di storage/app/public/barang/
        //     $path = $request->file('picture')->storeAs('barang', $filename, 'public');

        //     $validated['gambar'] = $path;
        // }


        Model_Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $barang = Model_Barang::findOrFail($id);
        $kategori = Model_Kategori::orderBy('nama_kategori')->get();
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

        if ($request->hasFile('picture')) {
            // hapus file lama jika ada
            if ($barang->gambar && \Storage::disk('public')->exists($barang->gambar)) {
                \Storage::disk('public')->delete($barang->gambar);
            }

            $filename = time() . '_' . uniqid() . '.' . $request->file('picture')->getClientOriginalExtension();
            $path = $request->file('picture')->storeAs('barang', $filename, 'public');
            $validated['gambar'] = $path;
        }


        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang diperbarui.');
    }


    public function destroy(Model_Barang $barang)
    {
        // hapus file gambar jika ada
        if ($barang->gambar && \Storage::disk('public')->exists($barang->gambar)) {
            \Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();
        return back()->with('success', 'Barang dan gambar berhasil dihapus.');
    }

}
