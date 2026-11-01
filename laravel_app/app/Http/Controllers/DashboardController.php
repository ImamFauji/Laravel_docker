<?php

namespace App\Http\Controllers;

use App\Models\Model_Barang;
use App\Models\Model_Kategori;

class DashboardController
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

        return view('dashboard', compact(
            'user',
            'totalBarang',
            'totalKategori',
            'lowStockBarang'
        ));
    }
}
