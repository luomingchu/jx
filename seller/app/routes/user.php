<?php

/**
 * @SWG\Resource(
 *  resourcePath="/user",
 *  description="用户模块"
 * )
 */

/**
 *
 * @SWG\Api(
 *   path="/login",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="UserLogin",
 *      summary="登录",
 *      notes="登录系统，获取系统登录状态会话。",
 *      type="Member",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="username",
 *              description="用户名或手机",
 *              paramType="query",
 *              required=true,
 *              type="string"
 *          ),
 *          @SWG\Parameter(
 *              name="password",
 *              description="密码",
 *              paramType="query",
 *              required=true,
 *              type="string"
 *          ),
 *          @SWG\Parameter(
 *              name="remember_me",
 *              description="记住我",
 *              paramType="query",
 *              required=false,
 *              type="boolean",
 *              defaultValue="false"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=402, message="帐号或密码不正确。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::post('login', [
    'as' => 'UserLogin',
    'uses' => 'UserController@login'
]);

/**
 *
 * @SWG\Api(
 *   path="/logout",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="UserLogout",
 *      summary="退出",
 *      notes="注销掉当前会话，并将登录状态从所有设备中移除。",
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=401, message="当前未登录。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::post('logout', [
    'as' => 'UserLogout',
    'uses' => 'UserController@logout'
]);

/**
 *
 * @SWG\Api(
 *   path="/signup",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="UserSignup",
 *      summary="注册",
 *      notes="用户注册，注册成功后会自动登录。",
 *      type="Member",
 *      @SWG\Parameters(

 *          @SWG\Parameter(
 *              name="mobile",
 *              description="手机号",
 *              paramType="query",
 *              required=true,
 *              type="string"
 *          ),
 *          @SWG\Parameter(
 *              name="password",
 *              description="密码",
 *              paramType="query",
 *              required=true,
 *              type="string"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::post('signup', [
    'as' => 'UserSignup',
    'uses' => 'UserController@signup'
]);

/**
 *
 * @SWG\Api(
 *   path="/auth",
 *   @SWG\Operation(
 *      method="GET",
 *      nickname="UserAuth",
 *      summary="检查状态",
 *      notes="检查当前Cookie的登录状态有效性。",
 *      type="Member",
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=401, message="登录状态无效。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::get('auth', [
    'as' => 'UserAuth',
    'uses' => 'UserController@auth'
]);

/**
 *
 * @SWG\Api(
 *   path="/user/info",
 *   @SWG\Operation(
 *      method="GET",
 *      nickname="UserInfo",
 *      summary="获取信息",
 *      notes="根据user_id获取用户的详细信息。",
 *      type="Member",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="user_id",
 *              description="用户ID",
 *              paramType="query",
 *              required=true,
 *              type="integer"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::get('user/info', [
    'as' => 'UserInfo',
    'uses' => 'UserController@info'
]);



/**
 * @SWG\Api(
 *  path="/user/bind-push",
 *  @SWG\Operation(
 *      method="POST",
 *      summary="平台用户绑定百度云推送用户系统",
 *      notes="平台用户绑定百度云推送用户系统",
 *      type="string",
 *      nickname="BindBaiduPush",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="push_user_id",
 *              description="百度云用户ID",
 *              type="string",
 *              required=true,
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="channel_id",
 *              description="百度云channelID",
 *              type="string",
 *              required=true,
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="device_info",
 *              description="用户客户端其他设备信息",
 *              type="string",
 *              required=false,
 *              paramType="query"
 *          )
 *      ),
 *      @SWG\ResponseMessage(code=402, message="提交表单数据验证失败或绑定失败"),
 *      @SWG\ResponseMessage(code=200, message="success")
 *  )
 * )
 */
Route::post('user/bind-push', [
    'before' => 'auth',
    'as' => 'BindBaiduPush',
    'uses' => 'UserController@postBindBaiduPush'
]);

/**
 * @SWG\Api(
 *  path="/user/password",
 *  @SWG\Operation(
 *      method="POST",
 *      nickname="ModifyPassword",
 *      summary="通过旧密码修改到新密码",
 *      notes="登录状态下，通过旧密码修改到新密码。",
 *      type="string",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="password",
 *              description="原始密码",
 *              type="string",
 *              required=true,
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="new_password",
 *              description="新的密码",
 *              type="string",
 *              required=true,
 *              paramType="query"
 *          )
 *      ),
 *      @SWG\ResponseMessage(code=402, message="提交参数错误提示"),
 *      @SWG\ResponseMessage(code=200, message="success")
 *  ),
 * )
 */
Route::post('user/password', [
    'before' => 'auth',
    'as' => 'ModifyPassword',
    'uses' => 'UserController@postPassword'
]);


/**
 * @SWG\Api(
 *  path="/user/reset-password",
 *  @SWG\Operation(
 *      method="POST",
 *      summary="用户重置密码",
 *      notes="用户重置密码。",
 *      type="string",
 *      nickname="resetPassword",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="mobile",
 *              type="string",
 *              description="用户绑定的手机号码",
 *              required=true,
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="smsvcode",
 *              type="string",
 *              description="短信验证码",
 *              required=true,
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="password",
 *              type="string",
 *              description="用户的新密码",
 *              required=true,
 *              paramType="query"
 *          )
 *      ),
 *      @SWG\ResponseMessage(code=402, message="提交参数错误提示"),
 *      @SWG\ResponseMessage(code=200, message="success")
 *  )
 * )
 */
Route::post('user/reset-password', [
    'as' => 'resetPassword',
    'uses' => 'UserController@resetPassword'
]);



/**
 *
 * @SWG\Api(
 *   path="/user/edit",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="UserEdit",
 *      summary="编辑信息",
 *      notes="编辑当前登录用户的个人信息。不传的字段为不修改。",
 *      type="Member",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="avatar_id",
 *              description="头像",
 *              paramType="query",
 *              type="integer"
 *          ),
 *          @SWG\Parameter(
 *              name="gender",
 *              description="性别",
 *              paramType="query",
 *              type="string",
 *              enum="['Man','Female']"
 *          ),
 *          @SWG\Parameter(
 *              name="birthday",
 *              description="出生年月",
 *              type="string",
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="signature",
 *              description="个性签名",
 *              type="string",
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="province_id",
 *              description="所在省份",
 *              type="integer",
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="city_id",
 *              description="所在城市",
 *              type="integer",
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="district_id",
 *              description="所在地区/县",
 *              type="integer",
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="real_name",
 *              description="真实姓名",
 *              type="string",
 *              paramType="query"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=401, message="当前未登录。"),
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=200, message="用户模型。")
 *      )
 *   )
 * )
 */
Route::post('user/edit', [
    'as' => 'UserEdit',
    'before' => 'auth',
    'uses' => 'UserController@edit'
]);