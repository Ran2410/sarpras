<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $rowPerPage = $request->input('row', 5);
        $barangs = Barang::with('kategori')->paginate($rowPerPage);
        $kategoris = Kategori::all();
        $totalRows = Barang::count();

        return view('barang.index', [
            'barangs' => $barangs,
            'kategoris' => $kategoris,
            'totalRows' => $totalRows,
            'rowPerPage' => $rowPerPage,
        ])->with('i', ($request->input('page', 1) - 1) * $rowPerPage);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer',
            'image_barang' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $barangs = new Barang();
        $barangs->nama_barang = $request->nama_barang;
        $barangs->stok_barang = $request->stok_barang;
        $barangs->kategori_id = $request->kategori_id;

        if ($request->hasFile('image_barang')) {
            $image = $request->file('image_barang');
            $imagePath = $image->store('images', 'public');
            $barangs->image_barang = $imagePath;
        }

        $barangs->save();

        return redirect()->route('barang.index')->with('success', 'Barang created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok_barang' => 'required|integer',
            'image_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $barangs = Barang::findOrFail($request->id);
        $barangs->nama_barang = $request->nama_barang;
        $barangs->stok_barang = $request->stok_barang;
        $barangs->kategori_id = $request->kategori_id;

        if ($request->hasFile('image_barang')) {
            if ($barangs->image_barang) {
                Storage::delete('public/' . $barangs->image_barang);
            }

            $image = $request->file('image_barang');
            $imagePath = $image->store('images', 'public');
            $barangs->image_barang = $imagePath;
        }

        $barangs->save();

        return redirect()->route('barang.index')->with('success', 'Barang updated successfully.');
    }
    public function edit($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id); 
        return response()->json([
            'id' => $barang->id,
            'nama_barang' => $barang->nama_barang,
            'stok_barang' => $barang->stok_barang,
            'kategori_id' => $barang->kategori_id,
            'image_barang' => $barang->image_barang,
        ]);
    }

    public function destroy($id)
    {
        $barangs = Barang::findOrFail($id);

        if ($barangs->image_barang) {
            Storage::delete('public/' . $barangs->image_barang);
        }

        $barangs->delete();

        return redirect()->route('barang.index')->with('success', 'Barang deleted successfully.');
    }
}
