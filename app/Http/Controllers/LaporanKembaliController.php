<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kembali;
use App\Models\Pinjam;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KembaliExport;

class LaporanKembaliController extends Controller
{
    public function index(Request $request)
    {

        $barangOptions = Kembali::with('pinjam.barang')
            ->get()
            ->pluck('pinjam.barang.nama_barang')
            ->unique()
            ->filter()
            ->prepend('Semua Barang');

        $pinjamOptions = Kembali::with('pinjam.user')
            ->get()
            ->pluck('pinjam.user.name')
            ->unique()
            ->filter()
            ->prepend('Semua Pinjam');

        $statusOptions = collect(['Semua Status', 'approved', 'rejected']);

        $query = Kembali::with(['pinjam.user', 'pinjam.barang', 'handledBy']);

        if ($request->has('barang') && $request->barang !== 'Semua Barang') {
            $query->whereHas('pinjam.barang', function($q) use ($request) {
                $q->where('nama_barang', $request->barang);
            });
        }

        if ($request->has('pinjam') && $request->pinjam !== 'Semua Pinjam') {
            $query->whereHas('pinjam.user', function($q) use ($request) {
                $q->where('name', $request->pinjam);
            });
        }

        if ($request->has('status') && $request->status !== 'Semua Status') {
            $query->where('status', $request->status === 'approved' ? true : false);
        }
        $kembalis = $query->orderBy('created_at', 'desc')->get();
        return view('laporan-kembali.index', compact(
            'kembalis', 
            'barangOptions',
            'pinjamOptions',
            'statusOptions'
        ));
    }

    public function export(Request $request)
    {
        $barangFilter = $request->input('barang', 'Semua Barang');
        $pinjamFilter = $request->input('pinjam', 'Semua Pinjam');
        $statusFilter = $request->input('status', 'Semua Status');

        $nama_file = 'laporan_pengembalian_' . date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new KembaliExport($barangFilter, $pinjamFilter, $statusFilter), $nama_file);
    }
}