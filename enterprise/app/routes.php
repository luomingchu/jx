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

Route::group([
    'before' => 'auth'
],
    function ()
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

        // 企业信息：显示
        Route::get('enterprise-info', [
            'name' => '企业基本信息管理',
            'as' => 'EnterpriseInfo',
            'uses' => 'EnterpriseController@showInfo'
        ]);

        // 企业信息：编辑
        Route::get('EditenterpriseInfo', [
            'name' => '编辑企业信息',
            'as' => 'EditEnterpriseInfo',
            'uses' => 'EnterpriseController@EditInfo'
        ]);

        // 企业信息：保存
        Route::post('enterpriseInfo', [
            'name' => '保存企业信息',
            'as' => 'SaveEnterpriseInfo',
            'uses' => 'EnterpriseController@saveInfo'
        ]);

        // 商品频道列表
        /*
         * Route::get('goods-channel/list', [ 'as' => 'GoodsChannelList', 'uses' => 'GoodsChannelController@getList' ]); // 商品频道新增&修改 Route::get('goods-channel/edit/{id?}', [ 'as' => 'GoodsChannelEdit', 'uses' => 'GoodsChannelController@edit' ]); // 商品频道保存 Route::post('goods-channel/save', [ 'as' => 'GoodsChannelSave', 'uses' => 'GoodsChannelController@save' ]); // 商品频道删除 Route::post('goods-channel/delete', [ 'as' => 'GoodsChannelDelete', 'uses' => 'GoodsChannelController@delete' ]);
         */

        // 商品分类列表
        Route::get('goods-category/list', [
            'name' => '商品分类管理',
            'as' => 'GoodsCategoryList',
            'uses' => 'GoodsCategoryController@getList'
        ]);
        // 商品分类新增&修改
        Route::get('goods-category/edit/{id?}', [
            'name' => '编辑商品分类',
            'as' => 'GoodsCategoryEdit',
            'uses' => 'GoodsCategoryController@edit'
        ]);
        // 获取某分类下级商品分类
        Route::get('goods-category/sub', [
            'name' => '获取子级商品分类',
            'as' => 'GoodsCategorySub',
            'uses' => 'GoodsCategoryController@subCategorys'
        ]);
        // 商品分类保存
        Route::post('goods-category/save', [
            'name' => '保存商品分类',
            'as' => 'GoodsCategorySave',
            'uses' => 'GoodsCategoryController@save'
        ]);
        // 商品分类删除
        Route::post('goods-category/delete', [
            'name' => '删除商品分类',
            'as' => 'GoodsCategoryDelete',
            'uses' => 'GoodsCategoryController@delete'
        ]);

        // 门店列表
        Route::get('storeList', [
            'name' => '门店管理',
            'as' => 'StoreList',
            'uses' => 'StoreController@getList'
        ]);
        // 门店新增编辑
        Route::get('storeEdit/{id?}', [
            'name' => '编辑门店信息',
            'as' => 'StoreEdit',
            'uses' => 'StoreController@getEdit'
        ]);
        // 门店保存
        Route::post('storeSave', [
            'name' => '保存门店信息',
            'as' => 'StoreSave',
            'uses' => 'StoreController@postSave'
        ]);
        // 门店删除
        Route::post('storeDelete', [
            'name' => '删除门店',
            'as' => 'StoreDelete',
            'uses' => 'StoreController@delete'
        ]);
        // 门店批量导入
        Route::post('import-store', [
            'name' => '门店批量导入',
            'as' => 'ImportStore',
            'uses' => 'StoreController@multiImportStore'
        ]);

        // 门店管理员模块
        Route::group([
            'prefix' => 'storeManager'
        ], function ()
        {
            // 获取区域负责人列表
            Route::get('am-list', [
                'name' => '区域负责人管理',
                'as' => 'AreaStoreManagerList',
                'uses' => 'StoreManagerController@getAreaManagerList'
            ]);
            // 编辑门店管理员
            Route::get('am-edit/{id?}', [
                'name' => '编辑区域负责人',
                'as' => 'AreaStoreManagerEdit',
                'uses' => 'StoreManagerController@getAreaManagerEdit'
            ]);
            // 保存门店管理员信息
            Route::post('am-save', [
                'name' => '保存区域负责人',
                'as' => 'AreaStoreManagerSave',
                'uses' => 'StoreManagerController@postAreaManagerSave'
            ]);
            // 删除门店管理员
            Route::post('am-delete', [
                'name' => '删除区域负责人',
                'as' => 'AreaStoreManagerDelete',
                'uses' => 'StoreManagerController@deleteAreaManager'
            ]);
            // 获取门店管理员列表
            Route::get('list', [
                'name' => '门店管理员管理',
                'as' => 'storeManagerList',
                'uses' => 'StoreManagerController@getList'
            ]);
            // 编辑门店管理员
            Route::get('edit/{group_id?}', [
                'name' => '编辑门店管理员',
                'as' => 'storeManagerEdit',
                'uses' => 'StoreManagerController@getEdit'
            ]);
            // 保存门店管理员信息
            Route::post('save', [
                'name' => '保存门店管理员',
                'as' => 'storeManagerSave',
                'uses' => 'StoreManagerController@postSave'
            ]);
            // 删除门店管理员
            Route::post('delete', [
                'name' => '删除门店管理员',
                'as' => 'storeManagerDelete',
                'uses' => 'StoreManagerController@delete'
            ]);
        });

        Route::group([
            'prefix' => 'staff'
        ], function ()
        {
            // 员工列表
            Route::get('staffList', [
                'name' => '员工管理',
                'as' => 'StaffList',
                'uses' => 'StaffController@getList'
            ]);
            // 员工编辑
            Route::get('staffEdit/{id?}', [
                'name' => '编辑员工信息',
                'as' => 'StaffEdit',
                'uses' => 'StaffController@getEdit'
            ]);
            // 员工保存
            Route::post('staffSave', [
                'name' => '保存员工信息',
                'as' => 'StaffSave',
                'uses' => 'StaffController@postSave'
            ]);
            // Excel批量导入员工
            Route::post('ImportExcelStaff', [
                'name' => '导入员工信息',
                'as' => 'ImportExcelStaff',
                'uses' => 'StaffController@importExcelStaff'
            ]);
            // 员工删除
            Route::post('staffDelete', [
                'name' => '删除员工',
                'as' => 'StaffDelete',
                'uses' => 'StaffController@delete'
            ]);
        });

        // 修改头像视图
        Route::get('avatar/upload', [
            'name' => '修改头像',
            'as' => 'AvatarUpload',
            'uses' => 'EnterpriseController@getAvatar'
        ]);
        // 上传头像
        Route::get('avatar/process', [
            'name' => '上传头像',
            'as' => 'AvatarProcess',
            'uses' => 'EnterpriseController@avatarProcess'
        ]);
        // 系统参数列表
        Route::get('configs/list', [
            'name' => '系统参数',
            'as' => 'ConfigsList',
            'uses' => 'ConfigsController@getList'
        ]);
        // 系统参数编辑
        Route::get('configs/edit/{key}', [
            'name' => '编辑系统参数',
            'as' => 'ConfigsEdit',
            'uses' => 'ConfigsController@edit'
        ]);
        // 系统参数保存
        Route::post('configs/save', [
            'name' => '保存系统参数',
            'as' => 'ConfigsSave',
            'uses' => 'ConfigsController@save'
        ]);

        // 企业设置视图
        Route::get('enterprise-config/edit', [
            'name' => '系统皮肤设置',
            'as' => 'EnterpriseConfigEdit',
            'uses' => 'EnterpriseConfigController@edit'
        ]);
        // 企业设置保存
        Route::post('enterprise-config/save', [
            'name' => '保存系统皮肤设置',
            'as' => 'EnterpriseConfigSave',
            'uses' => 'EnterpriseConfigController@save'
        ]);

        // 任务列表及编辑视图
        Route::get('task/list', [
            'name' => '任务管理',
            'as' => 'TaskList',
            'uses' => 'TaskController@getList'
        ]);
        // 任务设置保存
        Route::post('task/save', [
            'name' => '保存任务',
            'as' => 'TaskSave',
            'uses' => 'TaskController@save'
        ]);
        // 编辑任务信息
        Route::get('task/edit/{task_id}', [
            'name' => '编辑任务',
            'as' => 'EditTask',
            'uses' => 'TaskController@getEdit'
        ]);

        // 用户商品建议列表
        Route::get('suggest/list', [
            'name' => '用户反馈管理',
            'as' => 'SuggestList',
            'uses' => 'SuggestController@getList'
        ]);
        // 用户商品建议编辑
        Route::get('suggest/edit/{id}', [
            'name' => '编辑用户反馈',
            'as' => 'SuggestEdit',
            'uses' => 'SuggestController@edit'
        ]);
        // 用户商品建议保存
        Route::post('suggest/save', [
            'name' => '保存用户反馈',
            'as' => 'SuggestSave',
            'uses' => 'SuggestController@save'
        ]);

        // 添加问卷调查
        Route::get('questionnaire/edit', [
            'name' => '添加问卷调查',
            'remark' => '',
            'as' => 'AddQuestionnaire',
            'uses' => 'QuestionnaireController@getEdit'
        ]);
        // 保存问卷调查信息
        Route::post('questionnaire/save', [
            'name' => '保存问卷调查信息',
            'remark' => '',
            'as' => 'SaveQuestionnaire',
            'uses' => 'QuestionnaireController@postSave'
        ]);
        // 获取问卷调查详细内容
        Route::get('questionnaire/info', [
            'name' => '获取问卷调查详细内容',
            'remark' => '',
            'as' => 'ViewQuestionnaireInfo',
            'uses' => 'QuestionnaireController@getInfo'
        ]);
        // 切换问卷调查状态
        Route::post('questionnaire/status', [
            'name' => '切换问卷调查状态',
            'remark' => '',
            'as' => 'ToggleQuestionnaireStatus',
            'uses' => 'QuestionnaireController@postToggleStatus'
        ]);
        // 切换问卷调查状态
        Route::post('questionnaire/delete', [
            'name' => '删除问卷调查',
            'remark' => '删除问卷调查',
            'as' => 'DeleteQuestionnaire',
            'uses' => 'QuestionnaireController@postDelete'
        ]);
        // 获取问卷调查列表
        Route::get('questionnaire/list', [
            'name' => '获取问卷调查列表',
            'remark' => '',
            'as' => 'GetQuestionnaireList',
            'uses' => 'QuestionnaireController@getList'
        ]);
        // 回答问卷调查
        Route::get('questionnaire/answer', [
            'name' => '回答问卷调查',
            'remark' => '',
            'as' => 'AnswerQuestionnaire',
            'uses' => 'QuestionnaireController@postAnswer'
        ]);
        // 个人对某个问卷的回答详情
        Route::get('questionnaire/member/answer', [
            'name' => '用户对问卷的回答内容',
            'remark' => '',
            'as' => 'MemberQuestionnaireAnswer',
            'uses' => 'QuestionnaireController@getMemberQuestionnaireAnswer'
        ]);

        // 指店列表
        Route::get('vstoreList', [
            'name' => '指店管理',
            'as' => 'VstoreList',
            'uses' => 'VstoreController@getList'
        ]);

        // 待审核指店列表
        Route::get('waitAuditVstoreList', [
            'name' => '待审核指店管理',
            'as' => 'WaitAuditVstoreList',
            'uses' => 'VstoreController@getList'
        ]);

        // 指店编辑
        Route::get('vstoreEdit/{id}', [
            'name' => '编辑指店',
            'as' => 'VstoreEdit',
            'uses' => 'VstoreController@getEdit'
        ]);

        // 指店保存
        Route::post('vstoreSave', [
            'name' => '保存指店',
            'as' => 'VstoreSave',
            'uses' => 'VstoreController@postSave'
        ]);
        // 指店等级管理
        Route::get('vstore-level', [
            'name' => '指店等级管理',
            'as' => 'VstoreLevelManage',
            'uses' => 'VstoreLevelController@index'
        ]);
        // 保存指店等级信息
        Route::post('setup-vstore-level', [
            'name' => '保存指店等级信息',
            'as' => 'SetupVstoreLevel',
            'uses' => 'VstoreLevelController@postSetupLevel'
        ]);

        // 活动管理
        Route::group([
            'prefix' => 'activity'
        ], function ()
        {
            // 活动列表
            Route::get('list', [
                'name' => '活动管理',
                'as' => 'ActivityList',
                'uses' => 'ActivityController@getList'
            ]);
            // 新增&修改活动
            Route::get('edit', [
                'name' => '编辑活动',
                'as' => 'ActivityEdit',
                'uses' => 'ActivityController@edit'
            ]);
            // 保存处理活动
            Route::post('save', [
                'name' => '保存活动',
                'as' => 'ActivitySave',
                'uses' => 'ActivityController@save'
            ]);
            // 活动删除
            Route::post('delete', [
                'name' => '删除活动',
                'as' => 'ActivityDelete',
                'uses' => 'ActivityController@delete'
            ]);
            // 开启活动
            Route::post('open-activity', [
                'name' => '开启活动',
                'as' => 'OpenActivity',
                'uses' => 'ActivityController@postOpenActivity'
            ]);
        });

        // 统计分析
        Route::group([
            'prefix' => 'report'
        ], function ()
        {
            // 订单统计分析
            Route::get('order', [
                'name' => '销售统计',
                'as' => 'ReportOrderList',
                'uses' => 'ReportController@getOrderList'
            ]);
            // 门店的订单统计分析
            Route::get('order/detail', [
                'name' => '门店销售详情',
                'as' => 'ReportOrderDetatil',
                'uses' => 'ReportController@getOrderDetatil'
            ]);
            // 指店的订单统计分析
            Route::get('order/detail2', [
                'name' => '指店销售详情',
                'as' => 'ReportOrderDetatil2',
                'uses' => 'ReportController@getOrderDetatil2'
            ]);
            // 用户统计分析
            Route::get('member-list', [
                'name' => '用户统计',
                'as' => 'ReportMemberList',
                'uses' => 'ReportController@getMemberList'
            ]);
            // 门店货款报表分析
            Route::get('store-brokerage', [
                'name' => '门店货款报表列表',
                'as' => 'ReportStoreBrokerageList',
                'uses' => 'ReportController@getStoreBrokerageList'
            ]);
            // 门店货款报表分析
            Route::get('store-brokerage-detail', [
                'name' => '门店货款明细',
                'as' => 'ReportStoreBrokerageDetail',
                'uses' => 'ReportController@getStoreBrokerageDetail'
            ]);
            // 全部导出门店货款报表到Excel
            Route::get('store-brokerage-excel', [
                'name' => '门店货款明细全部导出到Excel',
                'as' => 'ReportStoreBrokerageExcel',
                'uses' => 'ReportController@exportStoreBrokerageExcel'
            ]);
            // 选择几个后导出门店货款报表到Excel
            Route::get('store-brokerage-excel2', [
                'name' => '门店货款明细部分导出到Excel',
                'as' => 'ReportStoreBrokerageExcel2',
                'uses' => 'ReportController@exportStoreBrokerageExcel2'
            ]);
            // 全部导出门店货款报表为银行报表
            Route::get('out-excel/store-brokerage/bank/all', [
                'name' => '门店货款明细全部导出为银行报表',
                'as' => 'ReportStoreBrokerageToBankAll',
                'uses' => 'ReportController@outStoreBrokerageToBankAll'
            ]);
            // 选择几个后导出门店货款报表到Excel
            Route::get('out-excel/store-brokerage/bank/some', [
                'name' => '门店货款明细部分导出到Excel',
                'as' => 'ReportStoreBrokerageToBankSome',
                'uses' => 'ReportController@outStoreBrokerageToBankSome'
            ]);
            // 指店统计
            Route::get('vstore-list', [
                'name' => '指店统计',
                'as' => 'ReportVstoreList',
                'uses' => 'ReportController@getVstoreList'
            ]);
            // 用户行为分析
            Route::get('member-behavior', [
                'as' => 'ReportMemberBehavior',
                'uses' => 'ReportController@getMemberBehavior'
            ]);
            // 用户指友属性分析
            Route::get('member-property', [
                'as' => 'ReportMemberProperty',
                'uses' => 'ReportController@getMemberProperty'
            ]);
            // 指店订单统计
            Route::get('order-list', [
                'as' => 'ReportVstoreOrderList',
                'uses' => 'ReportController@getVstoreOrderList'
            ]);
            // 指店成交量统计
            Route::get('order-numlist', [
                'as' => 'ReportOrderNumList',
                'uses' => 'ReportController@getOrderNumList'
            ]);
            // 指店佣金报表
            Route::get('brokerage-list', [
                'as' => 'ReportBrokerageList',
                'name' => '指店佣金报表',
                'uses' => 'ReportController@getBrokerageList'
            ]);
            // 部分导出指店佣金报表
            Route::get('out-excel/vstore-brokerage/some', [
                'as' => 'OutExcelForVstoreBrokerageSome',
                'name' => '部分导出指店佣金报表',
                'uses' => 'ReportController@outExcelForVstoreBrokerageSome'
            ]);
            // 全部导出指店佣金报表
            Route::get('out-excel/vstore-brokerage/all', [
                'as' => 'OutExcelForVstoreBrokerageAll',
                'name' => '全部导出指店佣金报表',
                'uses' => 'ReportController@outExcelForVstoreBrokerageAll'
            ]);
            // 部分导出指店佣金报表为银行报表
            Route::get('out-excel/bank/some', [
                'as' => 'OutExcelToBankSome',
                'name' => '部分导出指店佣金报表到银行报表',
                'uses' => 'ReportController@outExcelToBankSome'
            ]);
            // 全部导出指店佣金报表为银行报表
            Route::get('out-excel/bank/all', [
                'as' => 'OutExcelToBankAll',
                'name' => '全部导出为银行报表',
                'uses' => 'ReportController@outExcelToBankAll'
            ]);
            // 给佣金记录（指店的订单）添加结算记录
            Route::post('brokerage/settlement', [
                'as' => 'BrokerageSettlement',
                'name' => '指店订单添加结算记录',
                'uses' => 'ReportController@postBrokerageSettlement'
            ]);
            // 指店佣金报表明细
            Route::get('brokerage-detail', [
                'as' => 'ReportBrokerageDetail',
                'name' => '指店佣金报表明细',
                'uses' => 'ReportController@getBrokerageDetail'
            ]);
            // 全部导出指店佣金明细报表到Excel
            Route::get('vstore-brokerage-excel', [
                'name' => '指店佣金明细全部导出到Excel',
                'as' => 'ReportVstoreBrokerageExcel',
                'uses' => 'ReportController@exportVstoreBrokerageExcel'
            ]);
        });

        // 企业组织模块
        Route::group([
            'prefix' => 'group'
        ], function ()
        {
            // 获取组织列表
            Route::get('list', [
                'name' => '区域管理',
                'as' => 'GroupList',
                'uses' => 'GroupController@getList'
            ]);
            // 编辑组织
            Route::get('edit/{group_id?}', [
                'name' => '编辑区域',
                'as' => 'EditGroup',
                'uses' => 'GroupController@getEdit'
            ]);
            // 保存组织信息
            Route::post('save', [
                'name' => '保存区域',
                'as' => 'SaveGroupInfo',
                'uses' => 'GroupController@postSave'
            ]);
            // 删除组织
            Route::post('delete', [
                'name' => '删除区域',
                'as' => 'DeleteGroup',
                'uses' => 'GroupController@postDelete'
            ]);
            // 获取某组织下级组织
            Route::get('group/sub', [
                'as' => 'GroupSub',
                'uses' => 'GroupController@subGroups'
            ]);
        });

        // 商品模块
        Route::group([
            'prefix' => 'goods'
        ], function ()
        {
            // 编辑商品信息
            Route::get('edit/{id?}', [
                'name' => '编辑商品',
                'as' => 'EnterpriseGoodsEdit',
                'uses' => 'GoodsController@edit'
            ]);

            // 保存商品信息
            Route::post('save', [
                'name' => '保存商品',
                'as' => 'SaveGoodsInfo',
                'uses' => 'GoodsController@postSave'
            ]);
            // 删除商品
            Route::post('delete-goods', [
                'name' => '删除商品',
                'as' => 'DeleteGoods',
                'uses' => 'GoodsController@postDelete'
            ]);
            // 切换商品状态
            Route::post('toggle-status', [
                'name' => '上下架商品',
                'as' => 'ToggleEnterpriseGoodsStatus',
                'uses' => 'GoodsController@postToggleStatus'
            ]);
            // 上架商品列表
            Route::get('list', [
                'name' => '上架商品管理',
                'as' => 'GetSaleEnterpriseGoodsList',
                'uses' => 'GoodsController@saleGoodsList'
            ]);
            // 下架商品列表
            Route::get('stock-list', [
                'name' => '仓库商品管理',
                'as' => 'GetRepertoryEnterpriseGoodsList',
                'uses' => 'GoodsController@repertoryGoodsList'
            ]);
        });

        Route::group([
            'prefix' => 'goods-type'
        ], function ()
        {
            // 获取商品类目列表
            Route::get('list', [
                'name' => '商品类目管理',
                'as' => 'GetGoodsTypeList',
                'uses' => 'GoodsTypeController@getList'
            ]);
            // 切换类目状态
            Route::post('toggle-status', [
                'name' => '切换类目状态',
                'as' => 'ToggleGoodsType',
                'uses' => 'GoodsTypeController@postType'
            ]);
        });

        // 公告管理
        Route::group([
            'prefix' => 'notice'
        ], function ()
        {
            // 编辑公告信息
            Route::get('edit', [
                'name' => '编辑公告',
                'as' => 'EditNotice',
                'uses' => 'NoticeController@getEdit'
            ]);
            // 保存公告信息
            Route::post('save', [
                'name' => '保存公告',
                'as' => 'SaveNotice',
                'uses' => 'NoticeController@postSave'
            ]);
            // 获取公告列表
            Route::get('list', [
                'name' => '公告管理',
                'as' => 'GetNoticeList',
                'uses' => 'NoticeController@getList'
            ]);
            // 切换公告状态
            Route::post('toggle-status', [
                'name' => '切换公告状态',
                'as' => 'ToggleNoticeStatus',
                'uses' => 'NoticeController@postToggleStatus'
            ]);
            // 删除公告
            Route::post('remove', [
                'name' => '删除功能',
                'as' => 'RemoveNotice',
                'uses' => 'NoticeController@postDeleteNotice'
            ]);
        });

        // 广告位管理
        Route::group([
            'prefix' => 'advertise-space'
        ], function ()
        {
            // 广告位列表
            Route::get('/', [
                'name' => '广告位管理',
                'as' => 'GetAdvertiseSpaceList',
                'uses' => 'AdvertiseSpaceController@getList'
            ]);
            // 编辑广告位
            Route::get('edit/{id?}', [
                'name' => '编辑广告位',
                'as' => 'EditAdvertiseSpace',
                'uses' => 'AdvertiseSpaceController@getEdit'
            ]);
            // 保存广告位信息
            Route::post('save', [
                'name' => '保存广告位',
                'as' => 'SaveAdvertiseSpace',
                'uses' => 'AdvertiseSpaceController@postSave'
            ]);
            // 删除广告位
            Route::post('delete', [
                'name' => '删除广告位',
                'as' => 'DeleteAdvertiseSpace',
                'uses' => 'AdvertiseSpaceController@postDelete'
            ]);
        });

        // 广告管理
        Route::group([
            'prefix' => 'advertise'
        ], function ()
        {
            // 广告列表
            Route::get('/', [
                'name' => '广告管理',
                'as' => 'GetAdvertiseList',
                'uses' => 'AdvertiseController@getList'
            ]);
            // 编辑广告
            Route::get('edit', [
                'name' => '编辑广告',
                'as' => 'EditAdvertise',
                'uses' => 'AdvertiseController@getEdit'
            ]);
            // 保存广告信息
            Route::post('save', [
                'name' => '保存广告',
                'as' => 'SaveAdvertise',
                'uses' => 'AdvertiseController@postSave'
            ]);
            // 删除广告
            Route::post('delete', [
                'name' => '删除广告',
                'as' => 'DeleteAdvertise',
                'uses' => 'AdvertiseController@postDelete'
            ]);
            // 切换广告状态
            Route::post('toggle-status', [
                'name' => '切换广告状态',
                'as' => 'ToggleAdvertiseStatus',
                'uses' => 'AdvertiseController@postToggleStatus'
            ]);
        });

        // 内购额
        Route::group([
            'prefix' => 'insource'
        ], function ()
        {
            // 编辑内购额
            Route::get('edit', [
                'name' => '发放内购额',
                'as' => 'EditMemberInsource',
                'uses' => 'InsourceController@getEdit'
            ]);
            // 按组发放内购额
            Route::post('grant-group', [
                'name' => '按组发放内购额',
                'as' => 'GrantByGroup',
                'uses' => 'InsourceController@postAddByGroup'
            ]);
            // 按用户发放内购额
            Route::post('grant-member', [
                'name' => '按用户发放内购额',
                'as' => 'GrantByMember',
                'uses' => 'InsourceController@postAddByMember'
            ]);
            // 获取用户内购额列表
            Route::get('list', [
                'name' => '用户内购额管理',
                'as' => 'GetInsourceLogList',
                'uses' => 'InsourceController@getList'
            ]);
        });

        // 指币
        Route::group([
            'prefix' => 'coin'
        ], function ()
        {
            // 编辑内购额
            Route::get('edit', [
                'name' => '发放指币',
                'as' => 'EditMemberCoin',
                'uses' => 'CoinController@getEdit'
            ]);
            // 按组发放内购额
            Route::post('grant-group', [
                'name' => '按组发放指币',
                'as' => 'GrantCoinByGroup',
                'uses' => 'CoinController@postAddByGroup'
            ]);
            // 按用户发放内购额
            Route::post('grant-member', [
                'name' => '按用户发放内购额',
                'as' => 'GrantCoinByMember',
                'uses' => 'CoinController@postAddByMember'
            ]);
            // 获取用户内购额列表
            Route::get('list', [
                'name' => '用户指币管理',
                'as' => 'GetCoinLogList',
                'uses' => 'CoinController@getList'
            ]);
        });

        // 佣金
        Route::group([
            'prefix' => 'brokerage'
        ], function ()
        {
            // 佣金管理
            Route::get('/', [
                'name' => '佣金管理',
                'as' => 'BrokerageManage',
                'uses' => 'BrokerageController@index'
            ]);
            // 确认结算佣金
            Route::post('confirm-settlement-brokerage', [
                'name' => '确认结算佣金',
                'as' => 'ConfirmSettlementBrokerage',
                'uses' => 'BrokerageController@postConfirmSettlementBrokerage'
            ]);
            // 结算佣金
            Route::post('settlement-brokerage', [
                'name' => '结算佣金',
                'as' => 'SettlementBrokerage',
                'uses' => 'BrokerageController@postSettlementBrokerage'
            ]);
        });

        // 订单管理
        Route::group([
            'prefix' => 'order'
        ], function ()
        {
            // 订单列表
            Route::get('order', [
                'name' => '订单管理',
                'as' => 'OrderList',
                'uses' => 'OrderController@index'
            ]);

            // 订单列表
            Route::get('wait-for-shipment', [
                'name' => '订单管理',
                'as' => 'WaitForShipmentOrderList',
                'uses' => 'OrderController@index'
            ]);

            // 订单详情
            Route::get('info/{order_id}', [
                'name' => '订单详情',
                'as' => 'ViewOrderInfo',
                'uses' => 'OrderController@getInfo'
            ]);
        });

        // 管理员管理模块
        Route::group([
            'prefix' => 'manager'
        ], function ()
        {
            // 编辑管理员信息
            Route::get('edit/{manager_id?}', [
                'name' => '编辑管理员',
                'as' => 'EditManagerInfo',
                'uses' => 'ManagerController@getEdit'
            ]);
            // 保存管理员信息
            Route::post('save', [
                'name' => '保存管理员',
                'as' => 'SaveManagerInfo',
                'uses' => 'ManagerController@postSave'
            ]);
            // 获取管理员列表
            Route::get('list', [
                'name' => '管理员管理',
                'as' => 'GetManagerList',
                'uses' => 'ManagerController@getList'
            ]);
            // 删除管理员
            Route::post('delete', [
                'name' => '删除管理员',
                'as' => 'DeleteManager',
                'uses' => 'ManagerController@postDelete'
            ]);
            // 切换管理员状态
            Route::post('toggle-status', [
                'name' => '切换状态',
                'as' => 'ToggleManagerStatus',
                'uses' => 'ManagerController@postToggleStatus'
            ]);
        });

        // 角色管理
        Route::group([
            'prefix' => 'role'
        ], function ()
        {
            // 角色管理
            Route::get('list', [
                'name' => '角色管理',
                'as' => 'GetRoleList',
                'uses' => 'RoleController@getList'
            ]);
            // 保存角色
            Route::post('save', [
                'name' => '保存角色',
                'as' => 'SaveRole',
                'uses' => 'RoleController@postSave'
            ]);
            // 删除角色
            Route::post('delete', [
                'name' => '删除角色',
                'as' => 'DeleteRole',
                'uses' => 'RoleController@postDelete'
            ]);
            // 切换角色状态
            Route::post('toggle-status', [
                'name' => '切换角色状态',
                'as' => 'ToggleRoleStatus',
                'uses' => 'RoleController@postToggleStatus'
            ]);
            // 查看角色权限
            Route::get('purview/{role_id}', [
                'name' => '查看角色权限',
                'as' => 'GetRolePurview',
                'uses' => 'RoleController@getAssignPurview'
            ]);
            // 保存角色权限
            Route::post('assign-purview', [
                'name' => '保存角色权限',
                'as' => 'SaveRolePurview',
                'uses' => 'RoleController@postAssignPurview'
            ]);
            // 查看角色成员
            Route::get('managers', [
                'name' => '查看角色成员',
                'as' => 'GetRoleManager',
                'uses' => 'RoleController@getManagers'
            ]);
            // 分配角色成员
            Route::post('assign-manager', [
                'name' => '分配角色成员',
                'as' => 'AssignRoleManager',
                'uses' => 'RoleController@postAssignManager'
            ]);
        });

        // 账户管理
        Route::group([
            'prefix' => 'account'
        ], function ()
        {
            // 账户管理首页
            Route::get('/', [
                'name' => '账户管理',
                'as' => 'AccountManage',
                'uses' => 'AccountManageController@index'
            ]);
            // 保存企业账户信息
            Route::post('save', [
                'name' => '保存企业账户信息',
                'as' => 'SaveAccountInfo',
                'uses' => 'AccountManageController@postSave'
            ]);
            // 批量导入门店账户信息
            Route::post('multi-import', [
                'name' => '批量导入门店账户信息',
                'as' => 'MultiImportStoreAccount',
                'uses' => 'AccountManageController@postMultiImportStoreAccount'
            ]);
            // 修改门店账户信息
            Route::post('save-store', [
                'name' => '保存门店账户信息',
                'as' => 'SaveStoreAccountInfo',
                'uses' => 'AccountManageController@postSaveStoreAccountInfo'
            ]);
            // 批量导出门店账户信息
            Route::get('export-store', [
                'name' => '批量导出门店账户信息',
                'as' => 'ExportStoreAccount',
                'uses' => 'AccountManageController@getExportStoreAccount'
            ]);
        });

        // 退款、退货模块
        Route::group([
            'prefix' => 'refund'
        ], function ()
        {
            // 退款管理
            Route::get('/', [
                'name' => '退款管理',
                'as' => 'RefundManage',
                'uses' => 'RefundController@index'
            ]);
            // 获取退款列表
            Route::get('items', [
                'name' => '获取退款申请列表',
                'as' => 'GetRefundItems',
                'uses' => 'RefundController@getRefundItems'
            ]);
            // 查看申请详情
            Route::get('info/{refund_id}', [
                'name' => '查看退款申请详情',
                'as' => 'GetRefundInfo',
                'uses' => 'RefundController@getInfo'
            ]);
            // 确认还款
            Route::post('', [
                'name' => '确认还款',
                'as' => 'AgreeRefundApply',
                'uses' => 'RefundController@postAgreeRefundApply'
            ]);
        });

        // 消息模块
        Route::group([
            'prefix' => 'message'
        ], function ()
        {
            // 获取消息列表
            Route::get('list', [
                'name' => '获取消息列表',
                'as' => 'GetMessageList',
                'uses' => 'MessageController@getList'
            ]);
            // 获取消息历史记录
            Route::get('history', [
                'name' => '消息管理',
                'as' => 'GetHistoryMessage',
                'uses' => 'MessageController@getHistory'
            ]);
            // 删除系统消息
            Route::post('delete', [
                'name' => '删除系统消息',
                'as' => 'DeleteMessage',
                'uses' => 'MessageController@postDelete'
            ]);
            // 编辑推送的消息
            Route::get('edit-push-message', [
                'name' => '编辑推送的消息',
                'as' => 'EditPushMessage',
                'uses' => 'MessageController@getPushMessage'
            ]);
            // 推送消息
            Route::post('push-message', [
                'name' => '推送app消息',
                'as' => 'PushMessage',
                'uses' => 'MessageController@postPushMessage'
            ]);
        });

        // 会员模块
        Route::group([
            'prefix' => 'member'
        ], function ()
        {
            // 获取会员管理
            Route::get('manage', [
                'as' => 'ManageMember',
                'name' => '会员管理',
                'uses' => 'UserController@getList'
            ]);
            // 编辑会员信息
            Route::get('edit', [
                'as' => 'EditMemberInfo',
                'name' => '编辑会员信息',
                'uses' => 'UserController@getEditMember'
            ]);
            // 保存会员信息
            Route::post('save', [
                'as' => 'SaveMemberInfo',
                'name' => '保存会员信息',
                'uses' => 'UserController@postSaveMember'
            ]);
            // 删除会员
            Route::post('delete', [
                'as' => 'DeleteMember',
                'name' => '删除会员',
                'uses' => 'UserController@postDelete'
            ]);
            // 批量导入会员
            Route::post('import', [
                'as' => 'MultiImportMember',
                'name' => '批量导入会员',
                'uses' => 'UserController@postMultiImportMember'
            ]);
        });

        // 会员等级
        Route::group([
            'prefix' => 'level'
        ], function ()
        {
            // 会员等级管理
            Route::get('manage', [
                'as' => 'ManageMemberLevel',
                'name' => '会员等级管理',
                'uses' => 'LevelController@index'
            ]);
            // 开启指定的会员等级
            Route::get('open', [
                'as' => 'OpenMemberLevel',
                'name' => '开启指定的会员等级',
                'uses' => 'LevelController@getOpenLevel'
            ]);
            // 保存等级信息
            Route::post('save', [
                'as' => 'SaveMemberLevel',
                'name' => '保存会员等级信息',
                'uses' => 'LevelController@postSetupLevel'
            ]);
        });
    });

// 企业商品列表Ajax
Route::get('enterprise-goods/list-ajax', [
    'as' => 'EnterpriseGoodsListAjax',
    'uses' => 'GoodsController@getListAjax'
]);
// 企业商品列表数Ajax
Route::get('enterprise-goods/list-count-ajax', [
    'as' => 'EnterpriseGoodsListCountAjax',
    'uses' => 'GoodsController@getListCountAjax'
]);
// 获取门店下的指店列表
Route::get('store/vstore-list', [
    'as' => 'GetVstoreList',
    'uses' => 'StoreController@ajaxVstoreList'
]);

// 获取子级组织
Route::get('group/sub-groups', [
    'as' => 'GetSubGroups',
    'uses' => 'GroupController@getSubGroups'
]);
// 获取某组织下级组织
Route::get('group/sub', [
    'as' => 'GroupSub',
    'uses' => 'GroupController@subGroups'
]);
// 获取指定组织下的门店列表
Route::get('group/store', [
    'as' => 'GetGroupStores',
    'uses' => 'GroupController@getGroupStores'
]);
// 获取某组织下级组织
Route::get('group/group/sub', [
    'as' => 'GroupSub',
    'uses' => 'GroupController@subGroups'
]);
// 获取商品库存配置页面
Route::get('goods/sku', [
    'as' => 'GetGoodsSkuView',
    'uses' => 'GoodsController@getSkuView'
]);
// 搜索商品列表
Route::get('goods/search', [
    'as' => 'SearchGoods',
    'uses' => 'GoodsController@searchGoodsList'
]);
// 异步检验商品型号是否存在
Route::get('goods/check-number', [
    'as' => 'CheckGoodsNumber',
    'uses' => 'GoodsController@ajaxCheckNumber'
]);
// 获取佣金列表
Route::get('brokerage/items', [
    'as' => 'GetBrokerageItems',
    'uses' => 'BrokerageController@getList'
]);
// 搜索企业用户
Route::get('search-member', [
    'as' => 'SearchMember',
    'uses' => 'UserController@ajaxSearchUser'
]);
// 获取未读消息数
Route::get('unread-message-number', [
    'as' => 'GetUnreadMessageNumber',
    'uses' => 'MessageController@getUnreadNumber'
]);
// 检查活动区域的有效性
Route::get('check-activity-valid', [
    'as' => 'CheckActivityGroupValid',
    'uses' => 'ActivityController@checkActivityGroupValid'
]);

Route::get('sync-member', function ()
{
    $list = MemberInfo::all();
    if (! $list->isEmpty()) {
        foreach ($list as $m) {
            if ($m->member_id) {
                $mg = Member::find($m->member_id);
                $m->mobile = $mg->mobile;
                $m->gender = $mg->gender;
                $m->real_name = $mg->real_name;
                $m->birthday = $mg->birthday;
                $m->save();
            }
        }
    }
    echo 'success';
});