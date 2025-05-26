<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class ApiKategoriController extends Controller
{
    public function index() {
        $kategoris = Kategori::all();

        return response()->json($kategoris);
    }

    public function show($id) {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }

        return response()->json($kategori);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json($kategori, 201);
    }

    public function update(Request $request, $id) {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return response()->json($kategori);
    }

    public function destroy($id) {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }

        $kategori->delete();

        return response()->json(['message' => 'Kategori deleted successfully']);
    }
}
