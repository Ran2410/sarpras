<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiBarangController extends Controller
{
    public function index() {
        $barangs = Barang::with('kategori')->get();

        return response()->json($barangs);
    }

    public function show($id) {
        $barang = Barang::with('kategori')->find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }

        return response()->json($barang);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer',
            'image_barang' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->stok_barang = $request->stok_barang;
        $barang->kategori_id = $request->kategori_id;

        if ($request->hasFile('image_barang')) {
            $image = $request->file('image_barang');
            $imagePath = $image->store('images', 'public');
            $barang->image_barang = $imagePath;
        }

        $barang->save();

        return response()->json($barang, 201);
    }

    public function update(Request $request, $id) {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer',
            'image_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $barang->nama_barang = $request->nama_barang;
        $barang->stok_barang = $request->stok_barang;
        $barang->kategori_id = $request->kategori_id;

        if ($request->hasFile('image_barang')) {
            if ($barang->image_barang) {
                Storage::delete('public/' . $barang->image_barang);
            }
            $image = $request->file('image_barang');
            $imagePath = $image->store('images', 'public');
            $barang->image_barang = $imagePath;
        }

        $barang->save();

        return response()->json($barang);
    }

    public function destroy($id) {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang not found'], 404);
        }

        if ($barang->image_barang) {
            Storage::delete('public/' . $barang->image_barang);
        }

        $barang->delete();

        return response()->json(['message' => 'Barang deleted successfully']);
    }
}
