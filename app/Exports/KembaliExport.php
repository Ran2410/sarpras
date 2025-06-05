<?php

namespace App\Exports;

use App\Models\Kembali;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KembaliExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $barangFilter;
    protected $peninjamFilter;
    protected $statusFilter;

    public function __construct($barangFilter, $peninjamFilter, $statusFilter)
    {
        $this->barangFilter = $barangFilter;
        $this->peninjamFilter = $peninjamFilter;
        $this->statusFilter = $statusFilter;
    }

    public function collection()
    {
        $query = Kembali::with(['pinjam.user', 'pinjam.barang']);

        if ($this->barangFilter && $this->barangFilter !== 'Semua Barang') {
            $query->whereHas('pinjam.barang', function($q) {
                $q->where('nama_barang', $this->barangFilter);
            });
        }

        if ($this->peninjamFilter && $this->peninjamFilter !== 'Semua Peninjam') {
            $query->whereHas('pinjam.user', function($q) {
                $q->where('name', $this->peninjamFilter);
            });
        }

        if ($this->statusFilter && $this->statusFilter !== 'Semua Status') {
            $query->where('status', $this->statusFilter === 'approved' ? true : false);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Barang',
            'Peninjam',
            'Jumlah',
            'Status',
            'Tanggal Pengembalian',
            'Disetujui Oleh'
        ];
    }

    public function map($kembali): array
    {
        return [
            $kembali->id,
            $kembali->pinjam->barang->nama_barang ?? '-',
            $kembali->pinjam->user->name ?? '-',
            $kembali->jumlah_kembali,
            $kembali->status ? 'approved' : 'rejected',
            $kembali->created_at->format('Y-m-d H:i:s'),
            $kembali->handledBy->name ?? 'admin'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            
            'A:G' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}