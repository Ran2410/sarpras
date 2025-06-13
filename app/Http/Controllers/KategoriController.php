<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $rowPerPage = $request->input('rows', 5); // Changed 'row' to 'rows' to match your select element
        $kategoris = Kategori::paginate($rowPerPage);
        $totalRows = Kategori::count();

        return view('kategori.index', compact('kategoris', 'totalRows'));
    }

    public function store(Request $request) // Changed from create() to store() for RESTful convention
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris', // Added unique validation
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $id
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Category updated successfully.');
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

        return redirect()->route('kategori.index')->with('success', 'Category deleted successfully.');
    }
}
