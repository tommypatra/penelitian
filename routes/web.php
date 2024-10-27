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
