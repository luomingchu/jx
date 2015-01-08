<?php

// 登录
Route::get('login', [
    'as' => 'Login',
    'uses' => 'UserController@showLogin'
]);
Route::post('login', [
    'as' => 'LoginAction',
    'uses' => 'UserController@postLogin'
]);

// 退出
Route::any('logout', [
    'as' => 'Logout',
    'uses' => 'UserController@logout'
]);

// 获取文件
Route::get('file', [
    'as' => 'FilePull',
    'uses' => 'StorageController@getFile'
]);

Route::group([
    'before' => 'auth'
], function ()
{

    // 仪表盘
    Route::get('/', [
        'as' => 'Dashboard',
        'uses' => 'HomeController@showDashboard'
    ]);

    // 上传文件
    Route::post('file', [
        'as' => 'FileUpload',
        'uses' => 'StorageController@postFile'
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

    // 会员管理
    Route::group([
        'prefix' => 'member'
    ], function ()
    {
        // 会员列表
        Route::get('list', [
            'as' => 'MemberList',
            'uses' => 'MemberController@showList'
        ]);

        // 待审核实名列表
        Route::get('real-name/list', [
            'as' => 'RealNameList',
            'uses' => 'MemberController@showRealNameList'
        ]);
        // 实名信息
        Route::get('real-name/info', [
            'as' => 'RealNameInfo',
            'uses' => 'MemberController@showRealNameInfo'
        ]);
        // 审核处理
        Route::post('real-name/verify', [
            'as' => 'RealNameVerify',
            'uses' => 'MemberController@postRealNameVerify'
        ]);

        // 反馈列表
        Route::get('suggestion/list', [
            'as' => 'SuggestionList',
            'uses' => 'MemberController@showSuggestionsList'
        ]);
        // 添加备注
        Route::get('suggestion/remark', [
            'as' => 'SuggestionEdit',
            'uses' => 'MemberController@editSuggestionsRemark'
        ]);
        // 反馈信息加备注
        Route::post('suggestion/remark', [
            'as' => 'SuggestionRemark',
            'uses' => 'MemberController@saveSuggestionRemark'
        ]);
    });

    Route::group([
        'prefix' => 'goods-type'
    ], function ()
    {
        // 获取商品类别列表
        Route::get('list', [
            'as' => 'GetGoodsTypeList',
            'uses' => 'GoodsTypeController@getList'
        ]);
        // 保存商品类别信息
        Route::post('save', [
            'as' => 'SaveGoodsType',
            'uses' => 'GoodsTypeController@postSave'
        ]);
        // 切换类别状态
        Route::post('toggle-status', [
            'as' => 'ToggleGoodsType',
            'uses' => 'GoodsTypeController@postToggleStatus'
        ]);
        // 删除类别
        Route::post('delete', [
            'as' => 'DeleteGoodsType',
            'uses' => 'GoodsTypeController@postDeleteType'
        ]);
        // 获取类别属性列表
        Route::get('attr-list', [
            'as' => 'GetGoodsTypeAttributes',
            'uses' => 'GoodsTypeController@getAttrList'
        ]);
        // 保存类别属性信息
        Route::post('save-attr', [
            'as' => 'SaveGoodsTypeAttribute',
            'uses' => 'GoodsTypeController@postSaveAttr'
        ]);
        // 删除类别属性
        Route::post('delete-attr', [
            'as' => 'DeleteGoodsTypeAttribute',
            'uses' => 'GoodsTypeController@postDeleteAttr'
        ]);
    });

    Route::group([
        'prefix' => 'enterprise'
    ], function ()
    {
        // 获取企业列表
        Route::get('list', [
            'as' => 'GetEnterpriseList',
            'uses' => 'EnterpriseController@getList'
        ]);
        // 编辑企业信息
        Route::get('edit', [
            'as' => 'EditEnterprise',
            'uses' => 'EnterpriseController@getEdit'
        ]);
        // 保存企业信息
        Route::post('save', [
            'as' => 'SaveEnterprise',
            'uses' => 'EnterpriseController@postSave'
        ]);
    });

    Route::group([
        'prefix' => 'bank'
    ], function ()
    {
        // 获取银行列表
        Route::get('list', [
            'as' => 'GetBankList',
            'uses' => 'BankController@getList'
        ]);
        // 编辑银行
        Route::get('edit', [
            'as' => 'EditBank',
            'uses' => 'BankController@getEdit'
        ]);
        // 保存银行信息
        Route::post('save', [
            'as' => 'SaveBank',
            'uses' => 'BankController@postSave'
        ]);
        // 删除银行信息
        Route::post('delete', [
            'as' => 'DeleteBank',
            'uses' => 'BankController@postDelete'
        ]);
    });

    // 账户管理
    Route::group([
        'prefix' => 'account'
    ], function()
    {
        // 编辑账户信息
        Route::get('edit', [
            'as' => 'EditAccountInfo',
            'uses' => 'AccountController@getAccountInfo'
        ]);
        // 保存账户信息
        Route::post('save', [
            'as' => 'SaveAccountInfo',
            'uses' => 'AccountController@postSave'
        ]);
    });

    Route::group([
        'prefix' => 'purview',
    ], function() {
        // 获取权限列表
        Route::get('list', [
            'as' => 'GetPurviewList',
            'uses' => 'PurviewController@getList'
        ]);
        // 保存权限信息
        Route::post('save', [
            'as' => 'SavePurviewInfo',
            'uses' => 'PurviewController@postSave'
        ]);
        // 删除权限信息
        Route::post('delete', [
            'as' => 'DeletePurview',
            'uses' => 'PurviewController@postDelete'
        ]);
        // 获取权限详情
        Route::get('info', [
            'as' => 'GetPurviewInfo',
            'uses' => 'PurviewController@getInfo'
        ]);
    });
});