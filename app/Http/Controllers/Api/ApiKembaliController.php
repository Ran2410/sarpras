<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kembali;
use App\Models\Pinjam;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiKembaliController extends Controller
{
    public function index()
    {
        $kembalis = Kembali::with(['pinjam.user', 'pinjam.barang'])->get();

        return response()->json($kembalis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pinjam_id' => 'required|exists:pinjams,id',
            'gambar_barang' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string', // Sesuaikan dengan input Flutter
        ]);

        $pinjam = Pinjam::where('id', $request->pinjam_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pinjam->status !== 'approved') {
            return response()->json(['message' => 'Pinjaman belum disetujui'], 400);
        }

        $imagePath = $request->file('gambar_barang')->store('images/barang_kembali', 'public');

        $kembali = Kembali::create([
            'pinjam_id' => $request->pinjam_id,
            'jumlah_kembali' => $pinjam->jumlah_pinjam,
            'gambar_barang' => $imagePath,
            'deskripsi' => $request->deskripsi, // Pastikan nama kolom di database sama
            'status' => false,
        ]);

        return response()->json([
            'message' => 'Pengembalian berhasil diajukan',
            'data' => $kembali,
        ], 201);
    }

    public function barangKembali(Request $request, $id)
    {
        $request->validate([
            'gambar_barang' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string|max:255',
        ]);

        $pinjam = Pinjam::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pinjam->status !== 'approved') {
            return response()->json(['message' => 'Pinjaman tidak valid'], 400);
        }

        $imagePath = $request->file('gambar_barang')->store('images/barang_kembali', 'public');

        $kembali = Kembali::create([
            'pinjam_id' => $pinjam->id,
            'jumlah_kembali' => $pinjam->jumlah_pinjam,
            'gambar_barang' => $imagePath,
            'deskripsi' => $request->deskripsi,
            'status' => false,
            'handled_by' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'Permintaan pengembalian berhasil diajukan',
            'status' => 'pending',
            'data' => $kembali,
        ], 201);
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

        return response()->json([
            'message' => 'Pengembalian berhasil disetujui oleh admin',
            'approved_by' => Auth::user()->name,
            'data' => $kembali
        ], 200);
    }
}
