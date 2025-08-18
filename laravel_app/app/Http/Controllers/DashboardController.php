<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Model_Barang;
use App\Models\Model_Kategori;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalBarang = Model_Barang::count();
        $totalKategori = Model_Kategori::count();

        // Barang dengan stok < 5 (low stock)
        $lowStockBarang = Model_Barang::with('kategori')
            ->where('jumlah_stock', '<', 5)
            ->orderBy('jumlah_stock')
            ->get();

        // Semua barang & kategori (jika mau ditampilkan di dashboard)
        $barang = Model_Barang::with('kategori')->get();
        $kategori = Model_Kategori::all();

        return view('dashboard', compact(
            'user',
            'barang',
            'kategori',
            'totalBarang',
            'totalKategori',
            'lowStockBarang'
        ));
    }
}

