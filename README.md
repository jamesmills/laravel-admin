# Laravel Admin Starter
A very simple admin panel for managing users, roles & permissions.

The premise for this package is to eradicate the duplicate work I do for every new Laravel project I setup.  

You will get a default user who has the role of admin. You will be able to log into the system with this user and manage all roles and permissions using a simple Bootstrap UI. The default `yourapp.local/admin` route will be restricted to users with admin role only. You will get a good default to build your application views and backend views separately.

## Installation

*Note:* This package should be run as soon as you have created a new laravel project.

1. Run
    ```
    composer require jamesmills/laravel-admin
    ```
2. Install the admin package.
    ```
    php artisan laravel-admin:install
    ```
3. Make sure your user model's has a ```HasRoles``` trait **app/User.php**.
    ```php
    use JamesMills\LaravelAdmin\Models\Traits\HasRoles;
 
    class User extends Authenticatable
    {
        use Notifiable, HasRoles;

        ...
    ```

## What this packages does

- Install the below packages
  - [laravelcollective/html](https://laravelcollective.com/docs/5.2/html)
  - [laracasts/flash](https://github.com/laracasts/flash)
- Run a migration
  - Create tables for `roles`, `role_user`, `permissions`, `permission_role`
- Create a new user `Admin User (admin@domain.com)` with the password `p455word`
- Publish the Laravel Auth view files using 'php artisan make:auth'
- Publish some additional [view/template](https://github.com/jamesmills/laravel-admin/tree/master/publish/resources/views) files
  - All CRUD view files for `users`, `roles` and `permissions`
  - A dedicated backend template `resources/views/templates/backend.blade.php`
- Replace the [AuthServiceProvider](https://github.com/jamesmills/laravel-admin/blob/master/publish/Providers/AuthServiceProvider.php) class with a new version
- Replace the web routes file with a [new version](https://github.com/jamesmills/laravel-admin/blob/master/publish/routes/web.php)

## Roles & Permissions

1. Create some roles.
2. Create some permissions.
3. Give permission(s) to a role.
4. Create user(s) with role.
5. For checking authenticated user's role see below:
    ```php
    // Check role anywhere
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        // Do admin stuff here
    }
    ```
6. For checking permissions see below:
    ```php
    if ($user->can('permission-name')) {
        // Do something
    }
    ```

Learn more about ACL from [here](https://laravel.com/docs/5.3/authorization)

## Acknowledgements

The origin of this package is a fork from [appzcoder/laravel-admin](https://github.com/appzcoder/laravel-admin) by [Sohel Amin](http://www.sohelamin.com). 

*Note:* I cloned the original project and created this so that I could remove the CRUD stuff.

