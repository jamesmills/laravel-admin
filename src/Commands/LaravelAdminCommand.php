<?php

namespace JamesMills\LaravelAdmin\Commands;

use App\User;
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

        if ($user = User::whereEmail('admin@domain.com')->first()) {
            $this->info("Admin user already exists (admin@domain.com / p455word)");
        } else {
            $this->info("Seed the users table with an admin user (admin@domain.com / p455word)");
            $this->call('db:seed', ['--class' => 'JamesMills\\LaravelAdmin\\Database\\Seeds\\DatabaseSeeder']);
        }

        $this->info("Successfully installed Laravel Admin!");
    }
}
