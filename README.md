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

## Usage

1. Create some roles.

2. Create some permissions.

3. Give permission(s) to a role.

4. Create user(s) with role.

5. For checking authenticated user's role see below:

    ```php
    // Check role anywhere
    if(Auth::check() && Auth::user()->hasRole('admin')) {
        // Do admin stuff here
    } else {
        // Do nothing
    }

    // Check role in route middleware
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'roles'], 'roles' => 'admin'], function () {
       Route::get('/', ['uses' => 'AdminController@index']);
    });
    ```

6. For checking permissions see below:

    ```php
    if($user->can('permission-name')) {
        // Do something
    }
    ```

Learn more about ACL from [here](https://laravel.com/docs/5.3/authorization)
