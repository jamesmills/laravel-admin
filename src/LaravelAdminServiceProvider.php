<?php

namespace JamesMills\LaravelAdmin;

use File;
use Illuminate\Support\ServiceProvider;
use JamesMills\LaravelAdmin\Middleware\CheckRole;

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
        /*
         * Will will leave the migration file in the package and load it via the Service Provider
         */
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        /*
         * We will load the route middleware using the Service Provider as an alias
         */
        $router->aliasMiddleware('roles', CheckRole::class);

        /*
         * We will set some controllers and resources to publish to the original project codebase
         */
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
        $this->commands('\\JamesMills\\LaravelAdmin\\Commands\\LaravelAdminCommand');
    }
}
