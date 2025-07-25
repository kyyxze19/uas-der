<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\Karyawan\Dashboard;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [AuthController::class, 'showLogin'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware("auth");

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/loginaction', [AuthController::class, 'login']);

Route::get('/kelola-karyawan', [karyawanController::class, 'kelola'])->name('kelolaKaryawan.karyawan');

Route::get('/karyawan', [KaryawanController::class, 'kelola'])->name('kelolaKaryawan.karyawan');
Route::post('/karyawan', [KaryawanController::class, 'store'])->name('kelolaKaryawan.karyawan');

Route::get('/review-karyawan', [KaryawanController::class, 'review'])->name('reviewkaryawan.review');

Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');

Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');


Route::get('/kelola-proyek', [ProyekController::class, 'index'])->name('kelola.proyek');
Route::get('/kelola-proyek/tambah', [ProyekController::class, 'create'])->name('proyek.create');
Route::post('/kelola-proyek', [ProyekController::class, 'store'])->name('proyek.store');

Route::get('/proyek', [ProyekController::class, 'index'])->name('proyek.index');
Route::get('/proyek/create', [ProyekController::class, 'create'])->name('proyek.create');
Route::post('/proyek', [ProyekController::class, 'store'])->name('proyek.store');
Route::get('/proyek/{id}', [ProyekController::class, 'show'])->name('proyek.show');
Route::get('/proyek/{id}/edit', [ProyekController::class, 'edit'])->name('proyek.edit');
Route::put('/proyek/{id}', [ProyekController::class, 'update'])->name('proyek.update');
Route::delete('/proyek/{id}', [ProyekController::class, 'destroy'])->name('proyek.destroy');


// Karyawan routes (protected)
Route::middleware('auth')->group(function () {
    Route::get('/karyawan/dashboard', [KaryawanController::class, 'dashboard'])->name('karyawan.dashboard');
    // Route untuk edit data pribadi karyawan
    Route::get('/karyawan/edit', [KaryawanController::class, 'editPribadi'])->name('karyawan.edit_pribadi');

    // === PERUBAHAN DI SINI ===
    // Ubah URI dari '/karyawan/edit' menjadi '/karyawan/profile/update' untuk menghindari konflik
    Route::put('/karyawan/profile/update', [KaryawanController::class, 'updatePribadi'])->name('karyawan.update_pribadi');
    
    Route::get('/karyawan/dokumen', [KaryawanController::class, 'showDokumen'])->name('karyawan.dokumen');
});

// Invoice routes
Route::resource('invoices', InvoiceController::class)->middleware('auth');
Route::patch('/invoices/{invoice}/update-status', [InvoiceController::class, 'updateStatus'])->name('invoices.update-status')->middleware('auth');
Route::get('/invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf')->middleware('auth');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});