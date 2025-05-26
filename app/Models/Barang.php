<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'stok_barang',
        'image_barang',
        'kategori_id'
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
