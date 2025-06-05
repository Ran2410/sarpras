<?php

namespace App\Exports;

use App\Models\Pinjam;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PinjamExport implements FromCollection, WithHeadings, WithMapping
{
    protected $barang_id;
    protected $user_id;
    protected $status;

    public function __construct($barang_id = null, $user_id = null, $status = null)
    {
        $this->barang_id = $barang_id;
        $this->user_id = $user_id;
        $this->status = $status;
    }

    public function collection()
    {
        return Pinjam::with(['barang', 'user'])
            ->when($this->barang_id, function ($query) {
                return $query->where('barang_id', $this->barang_id);
            })
            ->when($this->user_id, function ($query) {
                return $query->where('user_id', $this->user_id);
            })
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Barang',
            'Peminjam',
            'Jumlah',
            'Status',
            'Jatuh Tempo',
            'Disetujui Oleh',
        ];
    }

   public function map($pinjam): array
{
    return [
        $pinjam->id,
        $pinjam->barang->nama_barang ?? '-',
        $pinjam->user->name ?? '-',
        $pinjam->jumlah_pinjam,
        $pinjam->status,
        $pinjam->jatoh_tempo ? \Carbon\Carbon::parse($pinjam->jatoh_tempo)->format('d-m-Y H:i') : '-',
        $pinjam->approvedBy->name ?? '-',
    ];
}
}
