<?php

namespace App\Providers;

use App\Models\Curhat;
use App\Models\IklanBaris;
use App\Models\IklanGambar;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useTailwind();

        View::composer('layouts.admin', function ($view) {
            $view->with('pendingCounts', auth()->user()?->isAdmin() ? [
                'admin.users.index' => User::where('status', User::STATUS_PENDING)->count(),
                'admin.iklan-gambar.index' => IklanGambar::where('status', 'Menunggu')->count(),
                'admin.iklan-baris.index' => IklanBaris::where('status', 'Menunggu')->count(),
                'admin.curhats.index' => Curhat::where('status', 'Baru')->count(),
            ] : []);
        });
    }
}
