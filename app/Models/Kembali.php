<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kembali extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pinjam_id',
        'jumlah_kembali',
        'status',
        'handled_by',
        'gambar_barang',
        'keterangan',
    ];

    public function pinjam()
    {
        return $this->belongsTo(Pinjam::class);
    }

    public function handledBy()
{
    return $this->belongsTo(User::class, 'handled_by');
}

}
