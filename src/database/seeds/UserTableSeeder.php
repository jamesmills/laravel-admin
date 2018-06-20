<?php

namespace JamesMills\LaravelAdmin\Database\Seeds;

use Illuminate\Database\Seeder;
use App\User;
use JamesMills\LaravelAdmin\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name'  => 'Admin',
            'label' => 'admin',
        ]);

        $user = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@domain.com',
            'password' => \Hash::make('p455word'),
        ]);

        $user->assignRole($role->label);
    }
}
