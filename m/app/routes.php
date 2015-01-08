<?php
use Illuminate\Support\Facades\Redirect;
Route::pattern('id', '[0-9]+');
Route::pattern('width', '[0-9]+');
Route::pattern('height', '[0-9]+');

// 登录
Route::get('login', [
    'as' => 'Login',
    'uses' => 'UserController@showLogin'
]);
Route::post('login', [
    'as' => 'LoginAction',
    'uses' => 'UserController@postLogin'
]);

// 注册

Route::get('signup', [
    'as' => 'Signup',
    'uses' => 'UserController@showSignup'
]);
Route::post('signup', [
    'as' => 'UserSignup',
    'uses' => 'UserController@signup'
]);

// 退出
Route::any('logout', [
    'as' => 'Logout',
    'uses' => 'UserController@logout'
]);

// 修改密码
Route::get('password', [
    'before' => 'auth',
    'name' => '编辑密码',
    'as' => 'GetModifyPassword',
    'uses' => 'UserController@getPassword'
]);

// 修改密码
Route::post('password', [
    'before' => 'auth',
    'name' => '保存密码',
    'as' => 'PostModifyPassword',
    'uses' => 'UserController@postPassword'
]);

// 获取文件
Route::get('file', [
    'as' => 'FilePull',
    'uses' => 'StorageController@getFile'
]);

// 获取城市列表
Route::get('city', [
    'as' => 'CityPull',
    'uses' => 'GlobalController@getCity'
]);

// 获取区县列表
Route::get('district', [
    'as' => 'DistrictPull',
    'uses' => 'GlobalController@getDistrict'
]);

Route::get('goods/list', [
    'as' => 'MGoodsList',
    'uses' => 'MController@getGoodsList'
]);

Route::group([
    'before' => 'auth'
], function ()
{
    // 仪表盘
    Route::get('/', [
        'name' => '首页',
        'as' => 'Dashboard',
        'uses' => 'HomeController@showDashboard'
    ]);

    // 上传文件
    Route::post('file', [
        'name' => '上传图片',
        'as' => 'FileUpload',
        'uses' => 'StorageController@postFile'
    ]);

    // ckeditor 上传文件
    Route::post('ck-file', [
        'name' => '上传商品详情图片',
        'as' => 'CKFileUpload',
        'uses' => 'CkEditorController@postFile'
    ]);

    // 购物车
    Route::group([
        'prefix' => 'cart',
    ], function()
    {
        // 加入购物车
        Route::post('add', [
            'as' => 'AddGoodsToCart',
            'uses' => 'CartController@postAddCart'
        ]);
        // 购物车，订单确认页
        Route::get('confirm', [
            'as' => 'ConfirmCart',
            'uses' => 'CartController@confirm'
        ]);
    });

    // 收货地址模块
    Route::group([
        'prefix' => 'address'
    ], function()
    {
        // 收货地址主页
        Route::get('index', [
            'as' => 'AddressList',
            'uses' => 'AddressController@index'
        ]);
        // 修改收货地址
        Route::get('edit', [
            'as' => 'EditAddress',
            'uses' => 'AddressController@getEdit'
        ]);
        // 保存收货地址
        Route::post('save', [
            'as' => 'SaveAddress',
            'uses' => 'AddressController@postSave'
        ]);
    });

    // 订单
    Route::group([
        'prefix' => 'order'
    ], function () {
        // 生成订单
        Route::post('add', [
            'as' => 'CreateOrder',
            'uses' => 'OrderController@postAdd'
        ]);
    });

    // 收银台
    Route::group([
        'prefix' => 'cashier'
    ], function()
    {
        // 付款
        Route::get('payment', [
            'as' => 'PaymentOrder',
            'uses' => 'CashierController@payment'
        ]);
        // 支付宝回调
        Route::get('alipay-callback', [
            'as' => 'AlipayCallback',
            'uses' => 'CashierController@alipayCallback'
        ]);
    });

});


// 商品模块
Route::group([
    'prefix' => 'goods'
], function()
{
    // 查看商品详情
    Route::get('info/{goods_id}/{vstore_id}', [
        'as' => 'ViewGoodsInfo',
        'uses' => 'GoodsController@getInfo'
    ]);
});
// 支付宝异步通知
Route::any('alipay-notify', [
    'as' => 'AlipayNotify',
    'uses' => 'CashierController@alipayNotify'
]);
// 获取城市列表
Route::get('address/city', [
    'as' => 'GetCityList',
    'uses' => 'AddressController@getCityList'
]);
// 获取区、县列表
Route::get('address/district', [
    'as' => 'GetDistrictList',
    'uses' => 'AddressController@getDistrictList'
]);


Route::get('cache', function() {
    echo Cache::get('key');
});