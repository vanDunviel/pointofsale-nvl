<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk', 
        'kategori_id', 
        'kuantitas', 
        'harga',
        'gambar_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // In your Produk model (app/Models/Produk.php)
}
