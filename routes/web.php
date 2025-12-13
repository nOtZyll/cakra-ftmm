<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Mahasiswa\PengajuanController;
use App\Http\Controllers\Mahasiswa\LpjController;
use App\Http\Controllers\StafOrmawa\ScreeningController;
use App\Http\Controllers\StafFakultas\VerifikasiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function () {
    $user = Auth::user();
    $role = $user->role->role_name ?? null;

    return match ($role) {
        'admin'         => redirect()->route('admin.dashboard'),
        'mahasiswa'     => redirect()->route('mahasiswa.dashboard'),
        'staf_ormawa'   => redirect()->route('staf_ormawa.dashboard'),
        'staf_fakultas' => redirect()->route('staf_fakultas.dashboard'),
        default         => view('dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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
    
    Route::resource('lpj', LpjController::class)->except(['index', 'create', 'store']); 
});

Route::middleware(['auth'])->prefix('staf-ormawa')->name('staf_ormawa.')->group(function () {
    Route::get('/dashboard', [ScreeningController::class, 'index'])->name('dashboard');
    Route::get('/screening/{pengajuan}', [ScreeningController::class, 'show'])->name('screening.show');
    Route::put('/screening/{pengajuan}', [ScreeningController::class, 'updateStatus'])->name('screening.update');
    Route::get('/screening/lpj/{lpj}', [ScreeningController::class, 'showLpj'])->name('screening.lpj.show');
    Route::put('/screening/lpj/{lpj}', [ScreeningController::class, 'updateLpjStatus'])->name('screening.lpj.update');
});

Route::middleware(['auth'])->prefix('staf-fakultas')->name('staf_fakultas.')->group(function () {
    Route::get('/dashboard', [VerifikasiController::class, 'dashboard'])->name('dashboard');
    Route::get('/verifikasi/rab/{pengajuan}', [VerifikasiController::class, 'showRab'])->name('verifikasi.rab');
    Route::put('/verifikasi/rab/{pengajuan}', [VerifikasiController::class, 'updateStatus'])->name('verifikasi.update');
    Route::get('/verifikasi/lpj/{lpj}', [VerifikasiController::class, 'showLpj'])->name('verifikasi.lpj.show');
    Route::put('/verifikasi/lpj/{lpj}', [VerifikasiController::class, 'updateLpjStatus'])->name('verifikasi.lpj.update');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

require __DIR__.'/auth.php';