<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BarangExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kategori_id;

    public function __construct($kategori_id = null)
    {
        $this->kategori_id = $kategori_id;
    }

    public function collection()
    {
        $query = Barang::with('kategori');
        
        if ($this->kategori_id) {
            $query->where('kategori_id', $this->kategori_id);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Barang',
            'Stok',
            'Kategori',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    public function map($barang): array
    {
        return [
            $barang->id,
            $barang->nama_barang,
            $barang->stok_barang,
            $barang->kategori->nama_kategori,
            $barang->created_at->format('d-m-Y H:i:s'),
            $barang->updated_at->format('d-m-Y H:i:s')
        ];
    }
}