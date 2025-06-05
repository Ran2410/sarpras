<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use App\Models\Barang;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PinjamExport;
use Illuminate\Http\Request;

class LaporanPinjamController extends Controller
{
    public function index(Request $request)
    {
        $barang_id = $request->barang_id;
        $user_id = $request->user_id;
        $status = $request->status;

        $pinjams = Pinjam::with(['barang', 'user', 'approvedBy'])
            ->when($barang_id, function($query) use ($barang_id) {
                return $query->where('barang_id', $barang_id);
            })
            ->when($user_id, function($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $barangs = Barang::all();
        $users = User::all();
        $statuses = [
            'dipinjam' => 'Dipinjam',
            'dikembalikan' => 'Dikembalikan',
            'hilang' => 'Hilang'
        ];

        return view('laporan-pinjam.index', compact(
            'pinjams', 
            'barangs',
            'users',
            'statuses',
            'barang_id',
            'user_id',
            'status'
        ));
    }

    public function export(Request $request)
    {
        $barang_id = $request->barang_id;
        $user_id = $request->user_id;
        $status = $request->status;

        $nama_file = 'laporan_pinjam_' . date('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new PinjamExport($barang_id, $user_id, $status), $nama_file);
    }
}
