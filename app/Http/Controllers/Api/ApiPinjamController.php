<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Pinjam;

class ApiPinjamController extends Controller
{
    public function index()
    {
        $pinjams = Pinjam::with(['user', 'barang'])->get();

        return response()->json($pinjams);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah_pinjam' => 'required|integer|min:1',
            'jatoh_tempo' => 'required|date',
        ]);

        $barang = Barang::find($request->barang_id);
        if (!$barang) {
            return response()->json([
                'message' => 'Barang tidak tersedia',
                'status' => false,
            ], 400);
        }

        if ($barang->stok_barang < $request->jumlah_pinjam) {
            return response()->json([
                'message' => 'Stok tidak mencukupi',
                'status' => 'error',
            ], 400);
        }

        $approved_at = $request->input('approved_at', null);

        $pinjam = Pinjam::create([
            'user_id' => auth()->user()->id,
            'barang_id' => $request->barang_id,
            'jumlah_pinjam' => $request->jumlah_pinjam,
            'status' => 'pending',
            'jatoh_tempo' => $request->jatoh_tempo,
            'approved_at' => $approved_at,
            'approved_by' => auth()->user()->id,
        ]);

        Log::info('Pinjam created', ['pinjam' => $pinjam]);

        return response()->json([
            'message' => 'Berhasil meminjam barang',
            'status' => 'success',
            'data' => $pinjam,
        ], 201);
    }



    public function approve(Request $request, $id)
    {
        $pinjam = Pinjam::findOrFail($id);

        if ($pinjam->status !== 'pending') {
            return response()->json([
                'message' => 'Pinjaman sudah diproses',
                'status' => 'error',
            ], 400);
        }
        $barang = Barang::findOrFail($pinjam->barang_id);

        if ($barang->stok_barang < $pinjam->jumlah_pinjam) {
            return response()->json([
                'message' => 'Stok tidak mencukupi saat persetujuan',
                'status' => 'error',
            ], 400);
        }

        $barang->stok_barang -= $pinjam->jumlah_pinjam;
        $barang->save();


        $pinjam->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->user()->id,
        ]);

        return response()->json([
            'message' => 'Pinjaman disetujui',
            'status' => 'success',
            'data' => $pinjam,
        ]);
    }

    public function reject(Request $request, $id)
    {
        $pinjam = Pinjam::findOrFail($id);

        if ($pinjam->status !== 'pending') {
            return response()->json([
                'message' => 'Pinjaman sudah diproses',
                'status' => 'error',
            ], 400);
        }

        $pinjam->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => auth()->user()->id,
        ]);

        return response()->json([
            'message' => 'Pinjaman ditolak',
            'status' => 'success',
            'data' => $pinjam,
        ]);
    }
}
