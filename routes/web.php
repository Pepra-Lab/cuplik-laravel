<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\CurhatController;
use App\Http\Controllers\RealCountController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminVideoController;
use App\Http\Controllers\Admin\AdminPollController;
use App\Http\Controllers\Admin\AdminCurhatController;
use App\Http\Controllers\Admin\AdminIklanGambarController;
use App\Http\Controllers\Admin\AdminIklanBarisController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminRealCountController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Web Routes - Public Portal
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::post('/artikel/{slug}/komentar', [ArticleController::class, 'storeComment'])->name('article.comment.store');

Route::get('/kanal/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');

Route::get('/video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');

Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::get('/api/search-live', [SearchController::class, 'liveSearch'])->name('api.search.live');

Route::get('/polling', [PollController::class, 'index'])->name('poll.index');
Route::post('/polling/vote', [PollController::class, 'vote'])->name('poll.vote');

Route::get('/curhat', [CurhatController::class, 'index'])->name('curhat.index');
Route::post('/curhat', [CurhatController::class, 'store'])->name('curhat.store');

Route::get('/real-count', [RealCountController::class, 'index'])->name('realcount.index');

// Info Pages
Route::prefix('info')->name('info.')->group(function () {
    Route::get('/redaksi', [InfoController::class, 'redaksi'])->name('redaksi');
    Route::get('/pedoman', [InfoController::class, 'pedoman'])->name('pedoman');
    Route::get('/disclaimer', [InfoController::class, 'disclaimer'])->name('disclaimer');
    Route::get('/iklan', [InfoController::class, 'iklan'])->name('iklan');
});

// Authentication
Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
Route::post('/masuk', [AuthController::class, 'login'])->name('login.post');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');
Route::get('/lupa-sandi', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/lupa-sandi', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('categories', AdminCategoryController::class)->except(['show', 'create', 'edit']);
    Route::resource('tags', AdminTagController::class)->except(['show', 'create', 'edit']);
    Route::resource('videos', AdminVideoController::class)->except(['show', 'create', 'edit']);
    Route::resource('polls', AdminPollController::class)->except(['show', 'create', 'edit']);

    // Curhat Rakyat
    Route::get('curhats', [AdminCurhatController::class, 'index'])->name('curhats.index');
    Route::patch('curhats/{curhat}/status', [AdminCurhatController::class, 'updateStatus'])->name('curhats.updateStatus');
    Route::delete('curhats/{curhat}', [AdminCurhatController::class, 'destroy'])->name('curhats.destroy');

    // Advertisements
    Route::resource('iklan-gambar', AdminIklanGambarController::class)->except(['show', 'create', 'edit']);
    Route::get('iklan-baris', [AdminIklanBarisController::class, 'index'])->name('iklan-baris.index');
    Route::patch('iklan-baris/{iklanBari}/status', [AdminIklanBarisController::class, 'updateStatus'])->name('iklan-baris.updateStatus');
    Route::delete('iklan-baris/{iklanBari}', [AdminIklanBarisController::class, 'destroy'])->name('iklan-baris.destroy');

    // Banners
    Route::resource('banners', AdminBannerController::class)->except(['show', 'create', 'edit']);

    // Real Count
    Route::get('real-count', [AdminRealCountController::class, 'index'])->name('realcount.index');
    Route::post('real-count/suara', [AdminRealCountController::class, 'updateSuara'])->name('realcount.updateSuara');

    // User Management
    Route::resource('users', AdminUserController::class)->except(['show', 'create', 'edit']);
});
