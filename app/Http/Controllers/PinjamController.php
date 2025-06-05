<?php

namespace App\Http\Controllers;

use App\Models\Pinjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamController extends Controller
{
    public function index(Request $request)
    {
        $rowPerPage = request()->input('row', 5);
        $pinjams = Pinjam::with(['user', 'barang'])
                    ->where('status', 'pending')
                    ->paginate($rowPerPage);
                    
        $totalRows = Pinjam::where('status', 'pending')->count();
        return view('pinjam.index', compact('pinjams', 'totalRows'));
    }

    public function show($id)
    {
        $pinjam = Pinjam::with(['user', 'barang'])->findOrFail($id);
        return view('pinjam.show', compact('pinjam'));
    }

    public function approve(Request $request, $id)
    {
        $pinjam = Pinjam::findOrFail($id);

        if ($pinjam->status !== 'pending') {
            return redirect()->route('pinjam.index')->with('error', 'Pinjaman sudah diproses');
        }

        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $barang = $pinjam->barang;
        if ($barang->stok_barang < $pinjam->jumlah_pinjam) {
            return redirect()->route('pinjam.index')->with('error', 'Stok tidak mencukupi');
        }

        $barang->stok_barang -= $pinjam->jumlah_pinjam;
        $barang->save();

        $pinjam->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('pinjam.index')->with('success', 'Pinjaman disetujui');
    }

    public function reject(Request $request, $id)
    {
        $pinjam = Pinjam::findOrFail($id);

        if ($pinjam->status !== 'pending') {
            return redirect()->route('pinjam.index')->with('error', 'Pinjaman sudah diproses');
        }

        if (auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $pinjam->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return redirect()->route('pinjam.index')->with('success', 'Pinjaman ditolak');
    }
}