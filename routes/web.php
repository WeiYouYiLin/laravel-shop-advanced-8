<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/', 'PagesController@root')->name('root');
// 在之前的路由里加上一个 verify 参数
Auth::routes(['verify' => true]);
// 让首页直接跳转到商品页面
Route::redirect('/', '/products')->name('root');
Route::get('products', 'ProductsController@index')->name('products.index');

// auth 中间件代表需要登录，verified中间件代表需要经过邮箱验证
Route::group(['middleware' => ['auth', 'verified']], function() {
	// 收货地址首页
    Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    // 新增收货地址页面
    Route::get('user_addresses/create', 'UserAddressesController@create')->name('user_addresses.create');
    // 存储收货地址
    Route::post('user_addresses', 'UserAddressesController@store')->name('user_addresses.store');
    // 编辑收货地址页面
    Route::get('user_addresses/{user_address}', 'UserAddressesController@edit')->name('user_addresses.edit');
    // 编辑收货地址操作
    Route::put('user_addresses/{user_address}', 'UserAddressesController@update')->name('user_addresses.update');
    // 删除收货地址
    Route::delete('user_addresses/{user_address}', 'UserAddressesController@destroy')->name('user_addresses.destroy');
    
	// 用户收藏产品
	Route::post('products/{product}/favorite', 'ProductsController@favor')->name('products.favor');
	// 用户取消收藏
    Route::delete('products/{product}/favorite', 'ProductsController@disfavor')->name('products.disfavor');
    // 用户收藏列表
    Route::get('products/favorites', 'ProductsController@favorites')->name('products.favorites');

    // 添加产品到购物车
    Route::post('cart', 'CartController@add')->name('cart.add');
    // 购物车产品
    Route::get('cart', 'CartController@index')->name('cart.index');
    // 移除购物车商品
    Route::delete('cart/{sku}', 'CartController@remove')->name('cart.remove');
    // 创建订单
    Route::post('orders', 'OrdersController@store')->name('orders.store');
    // 订单列表
    Route::get('orders', 'OrdersController@index')->name('orders.index');
    // 订单详情
    Route::get('orders/{order}', 'OrdersController@show')->name('orders.show');

    // 支付宝支付
    Route::get('payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
    // 支付宝前端回调页面
    Route::get('payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');

    // 微信支付
    Route::get('payment/{order}/wechat', 'PaymentController@payByWechat')->name('payment.wechat');

});

// 产品详情 （为避免与用户收藏列表冲突，将路由放在收藏列表路由的下方）
Route::get('products/{product}', 'ProductsController@show')->name('products.show');

// 支付宝服务器端回调
Route::post('payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
// 支付宝测试
Route::get('alipay', function() {
    return app('alipay')->web([
        'out_trade_no' => time(),
        'total_amount' => '1',
        'subject' => 'test subject - 测试',
    ]);
});

// 微信支付回调
Route::post('payment/wechat/notify', 'PaymentController@wechatNotify')->name('payment.wechat.notify');