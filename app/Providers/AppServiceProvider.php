<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Log;

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
        view()->composer('*', function ($view) {
            $notificationCount = 0;
            if (Auth::check() && Auth::user()->class) {
                $className = Auth::user()->class->name; // Make sure you get the name property, not the object
                $notificationCount = \App\Models\ClassAnnouncement::where('class_name', $className)->count();
            }
            $view->with('notificationCount', $notificationCount);
        });
    }
}
