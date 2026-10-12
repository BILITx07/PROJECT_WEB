<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Item;
use Carbon\Carbon;

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
        Carbon::setLocale('id');

        if (!app()->runningInConsole()) {
            $port = request()->getPort();
            if ($port == 8001) {
                config(['session.cookie' => 'camprent_user_session']);
            } else {
                config(['session.cookie' => 'camprent_admin_session']);
            }
        }

        // Share categories with the user layout for the navigation dropdown
        View::composer('layouts.user', function ($view) {
            $categories = Item::select('category')->distinct()->pluck('category')->filter()->sort()->toArray();
            $view->with('navCategories', $categories);
        });
    }
}
