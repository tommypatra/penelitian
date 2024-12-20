<?php

use App\Models\User;
use App\Mail\KirimEmail;
//---------- sementera untuk kirim email
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;

Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/callback', [AuthController::class, 'handleGoogleCallback']);

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
Route::get('/dosen-surat-penugasan', [WebController::class, 'dosenSuratPenugasan'])->name('dosen-surat-penugasan');

//untuk umum
Route::get('/cetak-surat-penugasan/{id}', [WebController::class, 'cetakSuratPenugasan'])->name('cetak-surat-penugasan');
Route::get('/cek-qrcode/{id}', [WebController::class, 'cekQrcode'])->name('cek-qrcode');

Route::get('/profil', [WebController::class, 'profil'])->name('profil');
Route::get('/pendaftaran', [WebController::class, 'pendaftaran'])->name('pendaftaran');


Route::get('/kirim-email', function () {
    // Mengirim email setelah berhasil commit transaksi
    Mail::to('tommyirawan.patra@gmail.com')->queue(new KirimEmail(
        'Test kirim email',
        [
            'konten' => '<h5>Konten coba kirim email</h5>',
        ],
        'mail.kirim'
    ));

    return 'Email telah dikirim!';
});

Route::get('/enkrip/{email}', function ($email) {
    echo enkrip($email);
});

Route::get('/dekrip/{text}', function ($text) {
    echo dekrip($text);
});
