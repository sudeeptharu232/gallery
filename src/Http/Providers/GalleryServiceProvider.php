<?php

namespace PrabidheeInnovations\Gallery\Http\Providers;

use Illuminate\Support\ServiceProvider;

class GalleryServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . "/../../resources/views", "gallery");
        $this->loadRoutesFrom(__DIR__ . "/../../routes/routes.php");
        $this->loadMigrationsFrom(__DIR__ . "/../../database/migrations");
    }
}
