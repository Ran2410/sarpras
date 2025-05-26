<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Pinjam;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $kategoriCount = Kategori::count();
        $barangCount = Barang::count();
        $pinjamCount = Pinjam::count();

        return view('dashboard', compact('userCount', 'kategoriCount', 'barangCount', 'pinjamCount'));
    }
}
