<?php

namespace JamesMills\LaravelAdmin;

use File;
use Illuminate\Support\ServiceProvider;

class LaravelAdminServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');

        $router->middleware('checkRole', __DIR__ . '/../Middleware/CheckRole');

        $this->publishes([
            __DIR__ . '/../publish/Controllers/' => app_path('Http/Controllers'),
            __DIR__ . '/../publish/resources/'   => base_path('resources'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'JamesMills\LaravelAdmin\Commands\LaravelAdminCommand'
        );
    }
}
