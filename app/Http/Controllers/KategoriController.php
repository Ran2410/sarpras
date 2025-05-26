<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{public function index(Request $request)
{
    $kategoris = Kategori::all();
    $rowPerPage = $request->input('row', 5);
    $kategori = Kategori::paginate($rowPerPage);
    $totalRows = Kategori::count(); 

    return view('kategori.index', compact('kategoris', 'totalRows'));
}


    public function create(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($request->id);
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        return redirect()->route('kategori.index')->with('success', 'Kategori updated successfully.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori deleted successfully.');
    }
}
