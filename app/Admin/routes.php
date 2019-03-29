<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    // 后台用户管理
    $router->get('users', 'UsersController@index');
    // 后台商品管理
    $router->get('products', 'ProductsController@index');

});
