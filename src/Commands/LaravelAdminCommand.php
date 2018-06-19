<?php

namespace JamesMills\LaravelAdmin\Commands;

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

        $this->info("Seed the users table with an admin user (admin@domain.com / p455word)");
        $this->call('db:seed', ['--class' => 'JamesMills\\LaravelAdmin\\Database\\Seeds\\DatabaseSeeder']);

        $this->info("Adding the routes");
        $routeFile = base_path('routes/web.php');

        $routes =
            <<<EOD
/*
|--------------------------------------------------------------------------
| These routes were added by jamesmills/laravel-admin page
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'roles'], 'roles' => 'admin'], function () {
    Route::get('/', 'Admin\AdminController@index')->name('dashboard');
    Route::resource('roles', '\JamesMills\LaravelAdmin\Controllers\Admin\RolesController');
    Route::resource('permissions', '\JamesMills\LaravelAdmin\Controllers\Admin\PermissionsController');
    Route::resource('users', '\JamesMills\LaravelAdmin\Controllers\Admin\UsersController');
});

EOD;

        File::append($routeFile, "\n" . $routes);

        $this->info("Overriding the AuthServiceProvider");
        $contents = File::get(__DIR__ . '/../../publish/Providers/AuthServiceProvider.php');
        File::put(app_path('Providers/AuthServiceProvider.php'), $contents);



        // TODO
        /*
         * class User extends Authenticatable
{
    use Notifiable, HasRoles;
         *
         */

        $this->info("Successfully installed Laravel Admin!");
    }
}
