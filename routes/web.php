<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Galeri
Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{id}', [GalleryController::class, 'show'])->name('galleries.show');

// Jadwal Kajian
Route::get('/kajian', [KajianController::class, 'index'])->name('kajian.index');

// Keuangan
Route::get('/keuangan', [FinanceController::class, 'index'])->name('keuangan.index');

// Program Sosial & Pendidikan
Route::get('/program', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/program/{slug}', [ProgramController::class, 'show'])->name('programs.show');

// Pengumuman & Agenda
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('pengumuman.index');

// Saran & Masukan
Route::view('/pengaduan', 'complaints.create')->name('complaints.create');
Route::view('/pengaduan/lacak', 'complaints.track')->name('complaints.track');
