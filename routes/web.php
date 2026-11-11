<?php

use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

// Halaman untuk tamu: hanya bisa dibuka bila BELUM login
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
});



// Halaman internal: hanya bisa dibuka bila SUDAH login
Route::middleware('auth')->group(function () {
    // Halaman awal diarahkan ke dashboard (dari Jobsheet 08)
    Route::get('/', fn () => redirect()->route('dashboard'));

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Endpoint DataTables Mahasiswa
    Route::get('/mahasiswa/data', [MahasiswaController::class, 'data'])
        ->name('mahasiswa.data');

    // CRUD Mahasiswa khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::resource('mahasiswa', MahasiswaController::class)
            ->except(['index', 'show']);
    });

    // Daftar dan detail mahasiswa untuk pengguna yang sudah login
    Route::resource('mahasiswa', MahasiswaController::class)
        ->only(['index', 'show']);
    // Route::get('/dosen', [DosenController::class, 'index'])
    //     ->name('dosen.index');
    // 1) Endpoint JSON DataTabels: HARUS di atas route yang memuat {dosen}
    Route::get('/dosen/data', [DosenController::class, 'data'])
        ->name('dosen.data');

    // 2) Tambah, Ubah, Hapus : khusus admin (role berjalan setelah auth)
    Route::middleware('role:admin')->group(function () {
        Route::resource('dosen', DosenController::class)->except(['index', 'show']);
    });

    // 3) Daftar dan detail: semua pengguna sudah yang sudah login
    Route::resource('dosen', DosenController::class)->only(['index', 'show']);

    Route::resource('mata-kuliah', MataKuliahController::class)
    ->parameters(['mata-kuliah' => 'matakuliah'])
    ->names('matakuliah');

    Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
    Route::get('/krs/create', [KrsController::class, 'create'])->name('krs.create');
    Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
    Route::get('/krs/{krs}/edit', [KrsController::class, 'edit'])->name('krs.edit');
    Route::put('/krs/{krs}', [KrsController::class, 'update'])->name('krs.update');
    Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])
    ->name('krs.destroy');

    // Dari Jobsheet 07; menampilkan versi PHP/MySQL dan nama database, jadi dilindungi
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');    
});

//Hanya Admin; middleware role berjalan SETELAH auth karena berada didalam grup auth
Route::get('/pengguna', [PenggunaController::class, 'index'])
    ->middleware('role:admin')
    ->name('pengguna.index');