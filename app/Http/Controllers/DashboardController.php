<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kategori;
use App\Models\Barang;
use App\Models\Pinjam;
use App\Models\Kembali;;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $userCount = User::count();
    $kategoriCount = Kategori::count();
    $barangCount = Barang::count();
    $pinjamCount = Pinjam::count();

        $recentPinjams = Pinjam::latest()->with('user', 'barang')->paginate(10);


    $recentPinjams = Pinjam::with(['user', 'barang'])
    ->whereIn('status', ['approved', 'returned', 'pending', 'rejected']) 
    ->orderBy('updated_at', 'desc')
    ->take(10)
    ->get();

    return view('dashboard', compact('userCount', 'kategoriCount', 'barangCount', 'pinjamCount', 'recentPinjams'));
}

}
