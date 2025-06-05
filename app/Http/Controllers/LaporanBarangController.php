<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangExport;

class LaporanBarangController extends Controller
{
    public function index(Request $request)
    {
        $kategori_id = $request->kategori_id;
        
        $barangs = Barang::with('kategori')
            ->when($kategori_id, function($query) use ($kategori_id) {
                return $query->where('kategori_id', $kategori_id);
            })
            ->get();
            
        $kategoris = Kategori::all();
        
        return view('laporan-barang.index', compact('barangs', 'kategoris', 'kategori_id'));
    }

    public function export(Request $request)
    {
        $kategori_id = $request->kategori_id;
            $nama_file = 'laporan_barang_' . date('Y-m-d_H-i-s') . '.xlsx';
            
            return Excel::download(new BarangExport($kategori_id), $nama_file);
    }
}