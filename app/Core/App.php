<?php

namespace App\Core;

class App
{
    public static function run(): void
    {
        // Simple PSR-4 Autoloader
        spl_autoload_register(function ($class) {
            $prefix = 'App\\';
            $base_dir = __DIR__ . '/../';

            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                return;
            }

            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
            }
        });

        // Initialize Router
        $router = new Router();

        // ---------------- GUEST ROUTES ----------------
        $router->get('/', 'HomeController@index');
        $router->get('/home', 'HomeController@index');
        $router->get('/menu', 'HomeController@menu');

        // ---------------- AUTH ROUTES ----------------
        $router->get('/login', 'AuthController@loginPage');
        $router->post('/login', 'AuthController@login');
        $router->get('/register', 'AuthController@registerPage');
        $router->post('/register', 'AuthController@register');
        $router->get('/logout', 'AuthController@logout');

        // ---------------- USER ROUTES ----------------
        $router->get('/user', 'UserController@index');
        $router->get('/user/menu', 'UserController@menu');
        $router->get('/cart', 'UserController@cart');
        $router->post('/cart', 'UserController@cartConfirm');
        $router->get('/cart/add', 'UserController@cartAdd');
        $router->get('/cart/remove', 'UserController@cartRemove');
        $router->get('/cart/clear', 'UserController@cartClear');

        // ---------------- ADMIN ROUTES ----------------
        $router->get('/admin', 'AdminController@orders');
        $router->get('/admin/orders/delete', 'AdminController@ordersDelete');
        $router->get('/admin/menu', 'AdminController@menu');
        $router->get('/admin/menu/add', 'AdminController@addPage');
        $router->post('/admin/menu/add', 'AdminController@add');
        $router->get('/admin/menu/edit', 'AdminController@editPage');
        $router->post('/admin/menu/edit', 'AdminController@edit');
        $router->get('/admin/menu/delete', 'AdminController@delete');

        // Dispatch Request
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        $router->dispatch($uri, $method);
    }
}
