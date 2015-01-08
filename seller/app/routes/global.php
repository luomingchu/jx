<?php

/**
 * @SWG\Resource(
 *  resourcePath="/global",
 *  description="系统全局"
 * )
 */

/**
 *
 * @SWG\Api(
 *   path="/captcha/sms",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="CaptchaSMSVcode",
 *      summary="获取短信验证码",
 *      notes="所有需要提供短信验证码的地方，都是通过此接口获取。",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="mobile",
 *              description="手机号码",
 *              paramType="query",
 *              required=true,
 *              type="string"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=403, message="不能在60内重复获取。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::post('captcha/sms', [
    'as' => 'CaptchaSMS',
    'uses' => 'CaptchaController@getSmsVcode'
]);

/**
 *
 * @SWG\Api(
 *   path="/captcha/email",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="CaptchaEmailVcode",
 *      summary="发送验证码到指定的邮箱",
 *      notes="所有需要提供邮箱验证码的地方，都是通过此接口获取。",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="email",
 *              description="邮箱地址",
 *              paramType="query",
 *              required=true,
 *              type="string"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=403, message="不能在60内重复获取。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::post('captcha/email', [
    'as' => 'CaptchaEmailVcode',
    'uses' => 'CaptchaController@getEmailVcode'
]);


/**
 * @SWG\Api(
 *  path="/captcha/checkSmsVcode",
 *  @SWG\Operation(
 *      method="POST",
 *      summary="手机短信码验证",
 *      notes="提供短信验证码验证。10分钟内有效",
 *      type="string",
 *      nickname="CheckSmsVcode",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="mobile",
 *              type="string",
 *              description="要绑定的手机号",
 *              required=true,
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="vcode",
 *              type="string",
 *              description="短信验证码",
 *              required=true,
 *              paramType="query"
 *          )
 *      ),
 *      @SWG\ResponseMessage(code=402, message="提交参数错误提示"),
 *      @SWG\ResponseMessage(code=200, message="success")
 *  )
 * )
 */
Route::post('captcha/checkSmsVcode', [
    'as' => 'CheckSmsVcode',
    'uses' => 'CaptchaController@checkSmsVcode'
]);

/**
 *
 * @SWG\Api(
 *   path="/file",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="FileUpload",
 *      summary="上传文件",
 *      notes="在所有接口中使用到文件ID，都由此接口得到。（注意使用文件上传方式 enctype=&quot;multipart/form-data&quot; ）",
 *      type="UserFile",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="file",
 *              description="文件",
 *              paramType="body",
 *              required=true,
 *              type="file"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=401, message="尚未登录。"),
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::post('file', [
    'as' => 'FileUpload',
    'before' => 'auth',
    'uses' => 'StorageController@postFile'
]);

/**
 *
 * @SWG\Api(
 *   path="/file",
 *   @SWG\Operation(
 *      method="GET",
 *      nickname="FilePull",
 *      summary="获取文件",
 *      notes="根据文件ID取得指定文件。如果文件是图片，支持获取指定宽高的缩略图。",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="id",
 *              description="文件ID",
 *              paramType="query",
 *              required=true,
 *              type="integer"
 *          ),
 *          @SWG\Parameter(
 *              name="width",
 *              description="宽度",
 *              paramType="query",
 *              type="integer"
 *          ),
 *          @SWG\Parameter(
 *              name="height",
 *              description="高度",
 *              paramType="query",
 *              type="integer"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=404, message="文件不存在。"),
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::get('file', [
    'as' => 'FilePull',
    'uses' => 'StorageController@getFile'
]);

/**
 *
 * @SWG\Api(
 *   path="/configs",
 *   @SWG\Operation(
 *      method="GET",
 *      nickname="GetConfigs",
 *      summary="获取企业参数",
 *      notes="可获取开店条件等企业的设置",
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=200, message="成功。")
 *      )
 *   )
 * )
 */
Route::get('configs', [
    'as' => 'GetConfigs',
    'uses' => 'ConfigsController@getConfigs'
]);


/**
 *
 * @SWG\Api(
 *   path="/app-check-update",
 *   @SWG\Operation(
 *      method="GET",
 *      nickname="AppCheckUpdate",
 *      summary="app版本检测更新",
 *      notes="app版本检测更新",
 *      @SWG\Parameter(
 *          name="type",
 *          description="app类型",
 *          paramType="query",
 *          required=true,
 *          type="string",
 *          enum="['Android', 'iOS']"
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=200, message="json数据")
 *      )
 *   )
 * )
 */
Route::get('app-check-update', [
'as' => 'AppCheckUpdate',
'uses' => 'BaseController@appCheckUpdate'
]);


/**
 *
 * @SWG\Api(
 *   path="/suggestion",
 *   @SWG\Operation(
 *      method="POST",
 *      nickname="GlobalSuggestion",
 *      summary="对软件提出反馈,key=feedback",
 *      notes="对网站本身提出的意见，如用户体验不佳，速度过慢，功能异常等，返回反馈模型,key=feedback",
 *      type="Suggestion",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="content",
 *              description="反馈内容",
 *              required=true,
 *              type="string",
 *              paramType="query"
 *          )
 *      ),
 *      @SWG\ResponseMessages(
 *          @SWG\ResponseMessage(code=401, message="当前未登录。"),
 *          @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *          @SWG\ResponseMessage(code=200, message="反馈模型。")
 *      )
 *   )
 * )
 */
Route::post('global/suggestion', [
'as' => 'GlobalSuggestion',
'before' => 'auth',
'uses' => 'GlobalController@sysSuggestion'
]);
