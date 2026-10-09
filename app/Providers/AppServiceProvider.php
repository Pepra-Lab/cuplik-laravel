<?php

namespace App\Providers;

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
            $user = auth()->user();

            $view->with('pendingUsers', $user?->isAdmin()
                ? User::where('status', User::STATUS_PENDING)->count()
                : 0);
        });
    }
}
