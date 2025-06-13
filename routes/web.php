    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\KategoriController;
    use App\Http\Controllers\BarangController;
    use App\Http\Controllers\PinjamController;
    use App\Http\Controllers\KembaliController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\LaporanBarangController;
    use App\Http\Controllers\LaporanPinjamController;
    use App\Http\Controllers\LaporanKembaliController;


    Route::get('/', function () {
        return view('welcome');
    });


    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User Management
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    });

    // Kategori Management
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    });


    // Barang Management
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
        Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
        Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    });

    // Pinjam Management
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/pinjam', [PinjamController::class, 'index'])->name('pinjam.index');
        Route::get('/pinjam/{id}', [PinjamController::class, 'show'])->name('pinjam.show');
        Route::post('/pinjam/{id}/approve', [PinjamController::class, 'approve'])
            ->middleware('admin')
            ->name('pinjam.approve');
        Route::post('/pinjam/{id}/reject', [PinjamController::class, 'reject'])
            ->middleware('admin')
            ->name('pinjam.reject');
    });

    // Kembali Management
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/kembali', [KembaliController::class, 'index'])->name('kembali.index');
        Route::get('/kembali/{id}', [KembaliController::class, 'show'])->name('kembali.show');
        Route::post('/kembali/{id}/approve', [KembaliController::class, 'approve'])
            ->middleware('admin')
            ->name('kembali.approve');
    });

    // Laporan Barang
    Route::prefix('laporan-barang')->group(function () {
        Route::get('/', [LaporanBarangController::class, 'index'])->name('laporan-barang.index');
        Route::get('/export', [LaporanBarangController::class, 'export'])->name('laporan-barang.export');
    });

    // Laporan Pinjam
    Route::prefix('laporan-pinjam')->group(function () {
        Route::get('/', [LaporanPinjamController::class, 'index'])->name('laporan-pinjam.index');
        Route::get('/export', [LaporanPinjamController::class, 'export'])->name('laporan-pinjam.export');
    });

    // Laporan Kembali
    Route::prefix('laporan-kembali')->group(function () {
        Route::get('/', [LaporankembaliController::class, 'index'])->name('laporan-kembali.index');
        Route::get('/export', [LaporanKembaliController::class, 'export'])->name('laporan-kembali.export');
    });
