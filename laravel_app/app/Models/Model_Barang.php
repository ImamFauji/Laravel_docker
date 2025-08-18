<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model_Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $fillable = [
        'nama',
        'kode_barang',
        'kategori_id',
        'jumlah_stock',
        'lokasi',
        'tanggal_kategori',
        'gambar',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)
            ->timezone('Asia/Jakarta')
            ->format('d-m-Y H:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)
            ->timezone('Asia/Jakarta')
            ->format('d-m-Y H:i:s');
    }

    public function kategori()
    {
        return $this->belongsTo(Model_Kategori::class, 'kategori_id');
    }
}