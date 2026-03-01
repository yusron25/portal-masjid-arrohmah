<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Berita / Artikel
Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');

// Galeri
Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{id}', [GalleryController::class, 'show'])->name('galleries.show');

// Pengaduan
Route::view('/pengaduan', 'complaints.create')->name('complaints.create');
Route::view('/pengaduan/lacak', 'complaints.track')->name('complaints.track');
