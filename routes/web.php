<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController; // <-- Impor Controller login
use App\Http\Controllers\Auth\RegisterController; // <-- Impor Controller register
use App\Http\Controllers\StaffOrmawaController;
use App\Http\Controllers\Mahasiswa\PengajuanController; // <-- Impor PengajuanController
use App\Http\Controllers\Mahasiswa\LpjController; // <-- Impor LpjController
use App\Http\Controllers\StafOrmawa\ScreeningController;
use App\Http\Controllers\StafFakultas\VerifikasiController;


/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('landing'))->name('landing');

/*
|--------------------------------------------------------------------------
| Auth Routes (NYATA)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Register Routes (NYATA)
|--------------------------------------------------------------------------
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


/*
|--------------------------------------------------------------------------
| Mahasiswa Routes (NYATA)
|--------------------------------------------------------------------------
| - Dibungkus dengan middleware 'auth' agar hanya bisa diakses setelah login.
| - Semua rute mengarah ke PengajuanController.
*/
    Route::middleware(['auth'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [PengajuanController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{pengajuan}', [PengajuanController::class, 'show'])->name('pengajuan.show');

    Route::get('/lpj', [LpjController::class, 'index'])->name('lpj.index');
    Route::get('/lpj/create/{pengajuan}', [LpjController::class, 'create'])->name('lpj.create');
    Route::post('/lpj/{pengajuan}', [LpjController::class, 'store'])->name('lpj.store');
    Route::get('/pengajuan/{pengajuan}/edit', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{pengajuan}', [PengajuanController::class, 'update'])->name('pengajuan.update');

        // ==================================================================
    // ==> TAMBAHKAN DUA ROUTE INI UNTUK REVISI LPJ <==
    Route::resource('lpj', LpjController::class);
    Route::get('/lpj/{lpj}/edit', [LpjController::class, 'edit'])->name('lpj.edit');
    Route::put('/lpj/{lpj}', [LpjController::class, 'update'])->name('lpj.update');
});

/*
|--------------------------------------------------------------------------
| Staf Ormawa Routes
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth'])->prefix('staf-ormawa')->name('staf_ormawa.')->group(function () {
    Route::get('/dashboard', [ScreeningController::class, 'index'])->name('dashboard');
    Route::get('/screening/{pengajuan}', [ScreeningController::class, 'show'])->name('screening.show');
    Route::put('/screening/{pengajuan}', [ScreeningController::class, 'updateStatus'])->name('screening.update');
    // Route untuk MENAMPILKAN halaman screening LPJ
    Route::get('/screening/lpj/{lpj}', [ScreeningController::class, 'showLpj'])->name('screening.lpj.show');

    // Route untuk MEMPROSES aksi (Setuju/Revisi) LPJ
    Route::put('/screening/lpj/{lpj}', [ScreeningController::class, 'updateLpjStatus'])->name('screening.lpj.update');
});

/*
|--------------------------------------------------------------------------
| Staf Fakultas Routes
|--------------------------------------------------------------------------
*/
    Route::middleware(['auth'])->prefix('staf-fakultas')->name('staf_fakultas.')->group(function () {
    // Arahkan dashboard ke method baru
    Route::get('/dashboard', [VerifikasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/verifikasi/rab/{pengajuan}', [VerifikasiController::class, 'showRab'])->name('verifikasi.rab');
    Route::put('/verifikasi/rab/{pengajuan}', [VerifikasiController::class, 'updateStatus'])->name('verifikasi.update');
    // Route untuk MENAMPILKAN halaman verifikasi LPJ
    Route::get('/verifikasi/lpj/{lpj}', [VerifikasiController::class, 'showLpj'])->name('verifikasi.lpj.show');

    // Route untuk MEMPROSES aksi (Setuju/Revisi) LPJ
    Route::put('/verifikasi/lpj/{lpj}', [VerifikasiController::class, 'updateLpjStatus'])->name('verifikasi.lpj.update');
});


