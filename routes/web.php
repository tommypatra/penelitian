<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'login']);
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::get('/dashboard', [WebController::class, 'dashboard'])->name('dashboard');

//untuk admin
Route::get('/unit-kerja', [WebController::class, 'unitKerja'])->name('unit-kerja');
Route::get('/pangkat', [WebController::class, 'pangkat'])->name('pangkat');
Route::get('/role', [WebController::class, 'role'])->name('role');
Route::get('/jenis-penelitian', [WebController::class, 'jenisPenelitian'])->name('jenis-penelitian');
Route::get('/user', [WebController::class, 'user'])->name('user');
Route::get('/jadwal-penelitian', [WebController::class, 'jadwalPenelitian'])->name('jadwal-penelitian');
Route::get('/dokumen-penelitian', [WebController::class, 'dokumenPenelitian'])->name('dokumen-penelitian');

//untuk admin dan jfu lppm
Route::get('/verifikasi', [WebController::class, 'verifikasi'])->name('verifikasi');
Route::get('/pengelola-surat-penugasan', [WebController::class, 'pengelolaSuratPenugasan'])->name('pengelola-surat-penugasan');


//untuk dosen
Route::get('/daftar-penelitian', [WebController::class, 'daftarPenelitian'])->name('daftar-penelitian');
Route::get('/timeline-penelitan/{peneliti_id}', [WebController::class, 'timelinePenelitan'])->name('timeline-penelitian');
