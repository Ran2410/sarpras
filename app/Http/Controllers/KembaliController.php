<?php

namespace App\Http\Controllers;

use App\Models\Kembali;
use App\Models\Pinjam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KembaliController extends Controller
{
    public function index(Request $request)
    {
        $rowPerPage = request()->input('row', 5);

        $kembalis = Kembali::with(['pinjam.user', 'pinjam.barang'])->paginate(5);
        $totalRows = Kembali::count();

        return view('kembali.index', compact('kembalis', 'totalRows', 'rowPerPage'));
    }

    public function show($id)
    {
        $kembali = Kembali::with(['pinjam.user', 'pinjam.barang'])->findOrFail($id);

        return view('kembali.show', compact('kembali'));
    }

    public function approve(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Hanya admin yang dapat menyetujui pengembalian',
                'success' => false
            ], 403);
        }

        $kembali = Kembali::findOrFail($id);

        if ($kembali->status === true) {
            return response()->json([
                'message' => 'Pengembalian sudah disetujui sebelumnya oleh: ' . ($kembali->approved_by ? User::find($kembali->approved_by)->name : 'Admin'),
                'current_status' => 'approved'
            ], 400);
        }

        DB::transaction(function () use ($kembali) {
            $pinjam = $kembali->pinjam;
            $barang = $pinjam->barang;

            $barang->stok_barang += $kembali->jumlah_kembali;
            $barang->save();

            $kembali->update([
                'status' => true,
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'handled_by' => Auth::id(),
            ]);

            $pinjam->update([
                'status' => 'returned',
                'returned_at' => now()
            ]);
        });

        return redirect()->route('kembali.index')->with('success', 'Pengembalian barang berhasil disetujui');
    }
}
