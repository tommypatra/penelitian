<?php

use Illuminate\Http\Request;
use App\Models\SuratPenugasan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PangkatController;
use App\Http\Controllers\PenelitiController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UnitKerjaController;
use App\Http\Controllers\PenelitianController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\SuratPenugasanController;
use App\Http\Controllers\JenisPenelitianController;
use App\Http\Controllers\DokumenPenelitianController;
use App\Http\Controllers\UploadDokumenPenelitiController;

Route::post('auth-cek', [AuthController::class, 'index']);
Route::get('daftar-unit-kerja', [UnitKerjaController::class, 'index']);
Route::get('daftar-pangkat', [PangkatController::class, 'index']);
Route::get('daftar-jenis-penelitian', [JenisPenelitianController::class, 'index']);
Route::get('daftar-jadwal-penelitian', [PenelitianController::class, 'index']);
Route::get('daftar-role', [RoleController::class, 'index']);
Route::post('simpan-pendaftaran', [UserController::class, 'create']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('cek-akses/{grup}', [WebController::class, 'cekAkses']);
    Route::get('user-role-detail/{user_id}', [UserRoleController::class, 'getUserRole']);
    Route::get('role-user', [AuthController::class, 'roleUser']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::resource('unit-kerja', UnitKerjaController::class);
    Route::resource('pangkat', PangkatController::class);
    Route::resource('user', UserController::class);
    Route::resource('jenis-penelitian', JenisPenelitianController::class);
    Route::resource('role', RoleController::class);
    Route::resource('penelitian', PenelitianController::class);
    Route::resource('user-role', UserRoleController::class);
    Route::resource('dokumen-penelitian', DokumenPenelitianController::class);
    Route::resource('peneliti', PenelitiController::class);
    Route::resource('upload-dokumen-peneliti', UploadDokumenPenelitiController::class);
    Route::resource('surat-penugasan', SuratPenugasanController::class);
    //khusus dosen finalisasi peneliti
    Route::put('finalisasi-peneliti/{id}', [PenelitiController::class, 'finalisasiPeneliti']);

    //khusus admin dan ketua lppm
    Route::put('penomoran-surat-penugasan/{id}', [SuratPenugasanController::class, 'penomoranSuratPenugasan']);
    Route::put('persetujuan-surat-penugasan/{id}', [SuratPenugasanController::class, 'persetujuanSuratPenugasan']);

    //khusus admin dan jfu
    Route::put('verifikasi-peneliti/{id}', [PenelitiController::class, 'verifikasiPeneliti']);

    //untuk verifikasi
    Route::get('surat-tugas-dosen', [SuratPenugasanController::class, 'suratTugasDosen']);
    Route::get('daftar-peneliti/{id}', [VerifikasiController::class, 'index']);
    Route::get('data-peneliti/{id}', [VerifikasiController::class, 'show']);
    Route::put('simpan-verifikasi-peneliti/{id}', [VerifikasiController::class, 'simpanVerifikasiPeneliti']);
    Route::put('simpan-verifikasi-berkas/{id}', [VerifikasiController::class, 'simpanVerifikasiBerkas']);
});
