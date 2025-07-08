<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\karyawanController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\Karyawan\Dashboard;
use App\Http\Controllers\InvoiceController;


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


    Route::get('/karyawan/dashboard', [Dashboard::class, 'index'])->name('karyawan.dashboard');
    // Tambahan route kalau lu nanti mau edit data pribadi & dokumen
    Route::get('/karyawan/edit', [Dashboard::class, 'edit'])->name('karyawan.edit_pribadi');
    Route::get('/karyawan/dokumen', [Dashboard::class, 'dokumen'])->name('karyawan.dokumen');

// Invoice routes
Route::resource('invoices', InvoiceController::class);
Route::patch('/invoices/{invoice}/update-status', [InvoiceController::class, 'updateStatus'])->name('invoices.update-status');
Route::get('/invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf');