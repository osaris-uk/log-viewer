<?php

namespace OsarisUk\LogViewer;

use Illuminate\Support\ServiceProvider;

class LogViewerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/log-viewer.php' => config_path('log-viewer.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/log-viewer'),
        ], 'views');

        $this->loadViewsFrom(__DIR__.'/views', 'log-viewer');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/log-viewer.php', 'log-viewer'
        );
    }
}
