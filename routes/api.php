<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ApiKategoriController;
use App\Http\Controllers\Api\ApiBarangController;
use App\Http\Controllers\Api\ApiKembaliController;
use App\Http\Controllers\Api\ApiPinjamController;

/*
|----------------------------------------------------------------------
| API Routes
|----------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|----------------------------------------------------------------------
*/
//Login Route
Route::post('/login', [AuthController::class, 'loginApi']);

Route::get('/barangs', [ApiBarangController::class, 'index']);

Route::get('/pinjams', [ApiPinjamController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    // Logout Route
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

    // Kategori Routes
    Route::get('/kategoris', [ApiKategoriController::class, 'index']);
    Route::get('/kategoris/{id}', [ApiKategoriController::class, 'show']);
    Route::post('/kategoris', [ApiKategoriController::class, 'store']);
    Route::put('/kategoris/{id}', [ApiKategoriController::class, 'update']);
    Route::delete('/kategoris/{id}', [ApiKategoriController::class, 'destroy']);

    // Barang Routes
    Route::post('/barangs', [ApiBarangController::class, 'store']);
    Route::put('/barangs/{id}', [ApiBarangController::class, 'update']);
    Route::delete('/barangs/{id}', [ApiBarangController::class, 'destroy']);

    // Pinjam Routes
    Route::post('/pinjams', [ApiPinjamController::class, 'store']);
    Route::put('/pinjams/approve/{id}', [ApiPinjamController::class, 'approve']);
    Route::put('/pinjams/reject/{id}', [ApiPinjamController::class, 'reject']);

   // Kembali Routes
    Route::get('/kembalis', [ApiKembaliController::class, 'index']);
    Route::post('/kembalis', [ApiKembaliController::class, 'store']); // Ubah dari '/kembalis/{id}'
    Route::post('/kembalis/{pinjamId}/kembalikan', [ApiKembaliController::class, 'barangKembali']); // Jika butuh ID pinjam
    Route::put('/kembalis/approve/{id}', [ApiKembaliController::class, 'approve']);
});
