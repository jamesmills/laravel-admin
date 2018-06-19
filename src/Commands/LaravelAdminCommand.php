<?php

namespace JamesMills\LaravelAdmin;

use File;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LaravelAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Laravel Admin.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info("Generating the authentication scaffolding");
        $this->call('make:auth');

        $this->info("Publishing the assets");
        $this->call('vendor:publish', ['--provider' => 'JamesMills\LaravelAdmin\LaravelAdminServiceProvider', '--force' => true]);

        $this->info("Dumping the composer autoload");
        (new Process('composer dump-autoload'))->run();

        $this->info("Migrating the database tables into your application");
        $this->call('migrate');

        $this->info("Adding the routes");
        $routeFile = base_path('routes/web.php');

        $routes =
            <<<EOD
Route::get('admin', 'Admin\\AdminController@index');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => 'admin'], function () {
    Route::resource('admin/roles', '\\JamesMills\\LaravelAdmin\\Controllers\\Admin\\\RolesController');
    Route::resource('admin/permissions', '\\JamesMills\\LaravelAdmin\\Controllers\\Admin\\PermissionsController');
    Route::resource('admin/users', '\\\JamesMills\\LaravelAdmin\\Controllers\\Admin\\UsersController');
});

EOD;

        File::append($routeFile, "\n" . $routes);

        $this->info("Overriding the AuthServiceProvider");
        $contents = File::get(__DIR__ . '/../publish/Providers/AuthServiceProvider.php');
        File::put(app_path('Providers/AuthServiceProvider.php'), $contents);

        $this->info("Successfully installed Laravel Admin!");
    }
}
