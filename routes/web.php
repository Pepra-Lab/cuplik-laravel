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
use App\Http\Controllers\PasswordResetController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminVideoController;
use App\Http\Controllers\Admin\AdminPollController;
use App\Http\Controllers\Admin\AdminCurhatController;
use App\Http\Controllers\Admin\AdminIklanGambarController;
use App\Http\Controllers\Admin\AdminIklanBarisController;
use App\Http\Controllers\Admin\AdminRealCountController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminIklanPosisiController;
use App\Http\Controllers\Admin\AdminIklanKategoriController;
use App\Http\Controllers\Admin\AdminInfoPageController;
use App\Http\Controllers\Admin\MemberIklanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Models\InfoPage;

/*
|--------------------------------------------------------------------------
| Web Routes - Public Portal
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::post('/artikel/{slug}/komentar', [ArticleController::class, 'storeComment'])->middleware('auth')->name('article.comment.store');

Route::get('/kanal/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/tag/{slug}', [TagController::class, 'show'])->name('tag.show');

Route::get('/video', [VideoController::class, 'index'])->name('video.index');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');

Route::get('/cari', [SearchController::class, 'index'])->name('search');
Route::get('/api/search-live', [SearchController::class, 'liveSearch'])->name('api.search.live');

Route::get('/polling', [PollController::class, 'index'])->name('poll.index');
Route::post('/polling/vote', [PollController::class, 'vote'])->name('poll.vote');

Route::get('/curhat', [CurhatController::class, 'index'])->name('curhat.index');
Route::post('/curhat', [CurhatController::class, 'store'])->middleware('auth')->name('curhat.store');

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
Route::post('/masuk', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.post');
Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->middleware('throttle:10,1')->name('register.post');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

Route::get('/lupa-sandi', [PasswordResetController::class, 'create'])->name('password.request');
Route::post('/lupa-sandi', [PasswordResetController::class, 'store'])->middleware('throttle:5,1')->name('password.email');
Route::get('/reset-sandi/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
Route::post('/reset-sandi', [PasswordResetController::class, 'update'])->middleware('throttle:5,1')->name('password.update');

/*
|--------------------------------------------------------------------------
| Admin CMS Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('cms')->group(function () {
    // Semua peran CMS (Redaktur dan Member dibatasi lewat policy)
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('articles', AdminArticleController::class)->except(['show']);
    Route::resource('videos', AdminVideoController::class)->except(['show', 'create', 'edit']);

    // Profil akun sendiri: tersedia untuk semua peran CMS, termasuk Redaktur dan Member
    Route::prefix('profil')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });

    // Khusus Member: iklan yang dikirim harus divalidasi admin
    Route::middleware('cms:member')->prefix('iklan-saya')->name('iklan-saya.')->group(function () {
        Route::get('/', [MemberIklanController::class, 'index'])->name('index');
        Route::post('gambar', [MemberIklanController::class, 'storeGambar'])->name('gambar.store');
        Route::post('baris', [MemberIklanController::class, 'storeBaris'])->name('baris.store');
        Route::delete('gambar/{iklanGambar}', [MemberIklanController::class, 'destroyGambar'])->name('gambar.destroy');
        Route::delete('baris/{iklanBari}', [MemberIklanController::class, 'destroyBaris'])->name('baris.destroy');
    });

    // Khusus Admin dan Super Admin
    Route::middleware('cms:admin')->group(function () {
        Route::resource('categories', AdminCategoryController::class)->except(['show', 'create', 'edit']);
        Route::resource('tags', AdminTagController::class)->except(['show', 'create', 'edit']);
        Route::resource('polls', AdminPollController::class)->except(['show', 'create', 'edit']);

        // Curhat Rakyat
        Route::get('curhats', [AdminCurhatController::class, 'index'])->name('curhats.index');
        Route::patch('curhats/{curhat}/status', [AdminCurhatController::class, 'updateStatus'])->name('curhats.updateStatus');
        Route::delete('curhats/{curhat}', [AdminCurhatController::class, 'destroy'])->name('curhats.destroy');

        // Advertisements
        Route::resource('iklan-gambar', AdminIklanGambarController::class)->except(['show', 'create', 'edit']);
        Route::patch('iklan-gambar/{iklanGambar}/status', [AdminIklanGambarController::class, 'updateStatus'])->name('iklan-gambar.updateStatus');
        Route::get('iklan-baris', [AdminIklanBarisController::class, 'index'])->name('iklan-baris.index');
        Route::patch('iklan-baris/{iklanBari}/status', [AdminIklanBarisController::class, 'updateStatus'])->name('iklan-baris.updateStatus');
        Route::delete('iklan-baris/{iklanBari}', [AdminIklanBarisController::class, 'destroy'])->name('iklan-baris.destroy');

        // Real Count Pilbup
        Route::prefix('real-count')->name('realcount.')->group(function () {
            Route::get('/', [AdminRealCountController::class, 'index'])->name('index');
            Route::post('suara', [AdminRealCountController::class, 'updateSuara'])->name('updateSuara');

            Route::get('calon', [AdminRealCountController::class, 'calon'])->name('calon');
            Route::post('calon', [AdminRealCountController::class, 'storePaslon'])->name('calon.store');
            Route::put('calon/{paslon}', [AdminRealCountController::class, 'updatePaslon'])->name('calon.update');
            Route::delete('calon/{paslon}', [AdminRealCountController::class, 'destroyPaslon'])->name('calon.destroy');

            Route::get('wilayah', [AdminRealCountController::class, 'wilayah'])->name('wilayah');
            Route::post('wilayah', [AdminRealCountController::class, 'storeDpt'])->name('wilayah.store');
            Route::put('wilayah/{dpt}', [AdminRealCountController::class, 'updateDpt'])->name('wilayah.update');
            Route::delete('wilayah/{dpt}', [AdminRealCountController::class, 'destroyDpt'])->name('wilayah.destroy');

            Route::get('pengaturan', [AdminRealCountController::class, 'pengaturan'])->name('pengaturan');
            Route::post('pengaturan', [AdminRealCountController::class, 'storePilbup'])->name('pengaturan.store');
            Route::put('pengaturan/{pilbup}', [AdminRealCountController::class, 'updatePilbup'])->name('pengaturan.update');
            Route::delete('pengaturan/{pilbup}', [AdminRealCountController::class, 'destroyPilbup'])->name('pengaturan.destroy');

            Route::get('rekapitulasi', [AdminRealCountController::class, 'rekap'])->name('rekap');
        });

        // User Management
        Route::resource('users', AdminUserController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::patch('users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::patch('users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');

        // Pengaturan: Profil Situs dan Posisi Iklan
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('profil', [AdminSettingController::class, 'profil'])->name('profil');
            Route::put('profil', [AdminSettingController::class, 'updateProfil'])->name('profil.update');
        });

        Route::resource('iklan-posisi', AdminIklanPosisiController::class)->except(['show', 'create', 'edit']);
        Route::resource('iklan-kategori', AdminIklanKategoriController::class)->except(['show', 'create', 'edit']);

        // Halaman Info: Disclaimer, Pedoman Media, Susunan Redaksi, Info Iklan
        Route::prefix('halaman-info')->name('info-pages.')->group(function () {
            Route::get('/', fn () => redirect()->route('admin.info-pages.edit', array_key_first(InfoPage::SLUGS)))->name('index');
            Route::get('{slug}', [AdminInfoPageController::class, 'edit'])->whereIn('slug', array_keys(InfoPage::SLUGS))->name('edit');
            Route::put('{slug}', [AdminInfoPageController::class, 'update'])->whereIn('slug', array_keys(InfoPage::SLUGS))->name('update');
        });

    });
});
