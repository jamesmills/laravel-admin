# Laravel Admin Starter
An admin panel for managing users, roles & permissions

## Acknowledgements

The origin of this package is a fork from [appzcoder/laravel-admin](https://github.com/appzcoder/laravel-admin) by [Sohel Amin](http://www.sohelamin.com). 

*Note:* I cloned the original project and created this so that I could remove the CRUD stuff and use this as a starter package to get going with an admin area with roles in new projects.

## Installation

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
    class User extends Authenticatable
    {
        use Notifiable, HasRoles;

        ...
    ```

## What this packages does

- Install the below packages
  - laravelcollective/html
  - laracasts/flash
  
- Run a migration to setup the below tables
  - roles
  - role_user
  - permissions
  - permission_role
  
- Create a new user 'Admin User (admin@domain.com)' with the password 'p455word'

- Publish the Laravel Auth view files using 'php artisan make:auth'

- Publish some additional view/template files

- Replace the 'AuthServiceProvider' class with a new version

- Replace the web routes file with a new version

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
