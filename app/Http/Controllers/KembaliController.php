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

        // Only show pending returns
        $kembalis = Kembali::with(['pinjam.user', 'pinjam.barang'])
                      ->where('status', false)
                      ->paginate($rowPerPage);
                      
        $totalRows = Kembali::where('status', false)->count();

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
            return redirect()->route('kembali.index')->with('error', 'Hanya admin yang dapat menyetujui pengembalian');
        }

        $kembali = Kembali::findOrFail($id);

        if ($kembali->status === true) {
            return redirect()->route('kembali.index')->with('error', 'Pengembalian sudah disetujui sebelumnya');
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