<?php

namespace App\Providers;

use App\Models\SchoolLevel;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('includes.*', function ($view) {
            $view->with('school_levels', SchoolLevel::orderBy('id')->get());
        });
    }
}
