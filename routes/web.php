<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController; // <-- Impor Controller login
use App\Http\Controllers\Auth\RegisterController; // <-- Impor Controller register
use App\Http\Controllers\StaffOrmawaController;

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
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', fn () => view('mahasiswa.dashboard', [
        'role' => 'mahasiswa',
        'user' => ['name' => 'Budi Mahasiswa']
    ]))->name('dashboard');

    Route::get('/pengajuan', fn () => view('mahasiswa.pengajuan.index', [
        'role' => 'mahasiswa',
        'user' => ['name' => 'Budi Mahasiswa']
    ]))->name('pengajuan.index');

    Route::get('/pengajuan/create', fn () => view('mahasiswa.pengajuan.create', [
        'role' => 'mahasiswa',
        'user' => ['name' => 'Budi Mahasiswa']
    ]))->name('pengajuan.create');

    Route::get('/pengajuan/show', fn () => view('mahasiswa.pengajuan.show', [
        'role' => 'mahasiswa',
        'user' => ['name' => 'Budi Mahasiswa']
    ]))->name('pengajuan.show');

    Route::get('/lpj/create', fn () => view('mahasiswa.lpj.create', [
        'role' => 'mahasiswa',
        'user' => ['name' => 'Budi Mahasiswa']
    ]))->name('lpj.create');
});

/*
|--------------------------------------------------------------------------
| Staf Ormawa Routes (dengan dummy data untuk $pengajuan)
|--------------------------------------------------------------------------
*/
Route::prefix('staf-ormawa')->name('staf_ormawa.')->group(function () {

    // Rute dashboard sekarang memanggil metode 'index' di StaffOrmawaController
    Route::get('/dashboard', [StaffOrmawaController::class, 'index'])->name('dashboard');

    // Rute screening sekarang memanggil metode 'show' di StaffOrmawaController
    Route::get('/screening/{id}', [StaffOrmawaController::class, 'show'])->name('screening.show');

});

/*
|--------------------------------------------------------------------------
| Staf Fakultas Routes
|--------------------------------------------------------------------------
*/
Route::prefix('staf-fakultas')->name('staf_fakultas.')->group(function () {
    // Dashboard utama
    Route::get('/dashboard', fn () => view('staf_fakultas.dashboard', [
        'role' => 'staf_fakultas',
        'user' => ['name' => 'Agus Fakultas']
    ]))->name('dashboard');

    // Verifikasi RAB (detail pengajuan RAB)
    Route::get('/verifikasi/rab/{id}', fn ($id) => view('staf_fakultas.verifikasi.rab_show', [
        'role' => 'staf_fakultas',
        'user' => ['name' => 'Agus Fakultas'],
        'id'   => $id,
    ]))->name('verifikasi.rab');

    // Verifikasi LPJ (detail pengajuan LPJ)
    Route::get('/verifikasi/lpj/{id}', fn ($id) => view('staf_fakultas.verifikasi.lpj_show', [
        'role' => 'staf_fakultas',
        'user' => ['name' => 'Agus Fakultas'],
        'id'   => $id,
    ]))->name('verifikasi.lpj');
});

/*
|--------------------------------------------------------------------------
| Stakeholder Routes
|--------------------------------------------------------------------------
*/
// routes/web.php

Route::prefix('stakeholder')->group(function () {
    Route::get('/dashboard', function () {
        // (Opsional) Hindari pakai $role di Blade, lebih aman cek Auth::user()
        $role = 'dekan';

        $kpi = [
            'dana_cair' => 1250000000,
            'delta_dana' => +12.4,
            'done' => 68,
            'lead_time' => 14.6,
            'fp_rate' => 72,
        ];

        $charts = [
            'danaCair' => [
                'labels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep'],
                'data'   => [120, 85, 140, 90, 210, 180, 230, 260, 195],
            ],
            'perOrmawa' => [
                'labels' => ['HIMA A','HIMA B','BEM','UKM C','UKM D'],
                'data'   => [350, 280, 420, 190, 210],
            ],
            'leadTime' => [
                'labels' => ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep'],
                'data'   => [16, 17, 15, 14, 12, 13, 14, 15, 14],
            ],
        ];

        $summary = [
            ['ormawa' => 'HIMA A', 'count' => 18, 'disetujui' => 520000000, 'cair' => 480000000, 'lead' => 13.2, 'fp' => 76],
            ['ormawa' => 'HIMA B', 'count' => 15, 'disetujui' => 410000000, 'cair' => 360000000, 'lead' => 15.1, 'fp' => 69],
            ['ormawa' => 'BEM',    'count' => 22, 'disetujui' => 690000000, 'cair' => 620000000, 'lead' => 12.7, 'fp' => 74],
            ['ormawa' => 'UKM C',  'count' => 9,  'disetujui' => 210000000, 'cair' => 190000000, 'lead' => 16.4, 'fp' => 70],
            ['ormawa' => 'UKM D',  'count' => 11, 'disetujui' => 240000000, 'cair' => 210000000, 'lead' => 15.8, 'fp' => 68],
        ];

        $filterOptions = [
            'ormawa' => ['All','HIMA A','HIMA B','BEM','UKM C','UKM D'],
            'tahun'  => [2024, 2025],
        ];

        return view('stakeholder.dashboard', compact('role','kpi','charts','summary','filterOptions'));
    })->name('stakeholder.dashboard');
});
