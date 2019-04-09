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
    // 后台商品管理列表
    $router->get('products', 'ProductsController@index');
    // 创建商品页面
    $router->get('products/create', 'ProductsController@create');
    // 创建商品操作
    $router->post('products', 'ProductsController@store');
    // 编辑商品页面
    $router->get('products/{id}/edit', 'ProductsController@edit');
    // 编辑商品操作
	$router->put('products/{id}', 'ProductsController@update');

    // 订单列表页
    $router->get('orders', 'OrdersController@index')->name('admin.orders.index');
    // 订单详情页
    $router->get('orders/{order}', 'OrdersController@show')->name('admin.orders.show');
});
