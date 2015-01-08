<?php
/**
 * @SWG\Resource(
 *  resourcePath="/vstore",
 *  description="指店模块"
 * )
 */

/**
 * @SWG\Api(
 *  path="/vstore/info",
 *  @SWG\Operation(
 *      method="GET",
 *      summary="获取指店详细信息",
 *      notes="获取指店详细信息",
 *      type="Vstore",
 *      nickname="GetVstoreInfo",
 *      @SWG\Parameter(
 *          name="vstore_id",
 *          description="指店ID",
 *          type="integer",
 *          required=true,
 *          paramType="query"
 *      ),
 *      @SWG\ResponseMessage(code=402, message="提交参数错误提示"),
 *      @SWG\ResponseMessage(code=200, message="指店模型")
 *  )
 * )
 */
Route::get('vstore/info', [
    'as' => 'GetVstoreInfo',
    'uses' => 'VstoreController@getInfo'
]);

/**
 * @SWG\Api(
 *  path="/vstore/apply-bystaff",
 *  @SWG\Operation(
 *      method="POST",
 *      summary="员工申请开店",
 *      notes="员工开店-只需填写指店名即可开通成功",
 *      type="Vstore",
 *      nickname="ApplyVstoreByStaff",
 *      @SWG\Parameter(
 *          name="name",
 *          description="指店名称",
 *          type="string",
 *          paramType="query",
 *          required=true
 *      ),
 *      @SWG\ResponseMessage(code=401, message="尚未登录。"),
 *      @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *      @SWG\ResponseMessage(code=200, message="指店模型")
 *  )
 * )
 */
Route::post('vstore/apply-bystaff', [
    'as' => 'ApplyVstoreByStaff',
    'before' => 'auth',
    'uses' => 'VstoreController@applyVstoreByStaff'
]);

/**
 * @SWG\Api(
 *  path="/vstore/apply",
 *  @SWG\Operation(
 *      method="POST",
 *      summary="非员工申请开店",
 *      type="Vstore",
 *      nickname="ApplyVstoreByNoStaff",
 *      @SWG\Parameter(
 *          name="name",
 *          description="指店名称",
 *          type="string",
 *          paramType="query",
 *          required=true
 *      ),
 *      @SWG\Parameter(
 *          name="real_name",
 *          description="真实姓名",
 *          type="string",
 *          required=true,
 *          paramType="query"
 *      ),
 *      @SWG\Parameter(
 *          name="id_number",
 *          description="身份证号码",
 *          type="string",
 *          required=true,
 *          paramType="query"
 *      ),
 *      @SWG\Parameter(
 *          name="id_picture_id",
 *          description="持证照",
 *          type="integer",
 *          required=true,
 *          paramType="query"
 *      ),
 *      @SWG\Parameter(
 *          name="store_id",
 *          description="门店ID",
 *          type="integer",
 *          required=true,
 *          paramType="query"
 *      ),
 *      @SWG\ResponseMessage(code=401, message="尚未登录。"),
 *      @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *      @SWG\ResponseMessage(code=200, message="指店模型")
 *  )
 * )
 */
Route::post('vstore/apply', [
    'as' => 'ApplyVstoreByNoStaff',
    'before' => 'auth',
    'uses' => 'VstoreController@applyVstoreByNoStaff'
]);

/**
 * @SWG\Api(
 *  path="/vstore/open",
 *  @SWG\Operation(
 *      method="POST",
 *      summary="领取店铺",
 *      notes="企业审核完成，领取登录者的店铺至开店成功",
 *      type="string",
 *      nickname="OpenVstore",
 *      @SWG\ResponseMessage(code=401, message="尚未登录。"),
 *      @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *      @SWG\ResponseMessage(code=200, message="success。")
 *  )
 * )
 */
Route::post('vstore/open', [
    'as' => 'OpenVstore',
    'before' => 'auth',
    'uses' => 'VstoreController@postOpenVstore'
]);

/**
 * @SWG\Api(
 *  path="/vstore/attention",
 *  @SWG\Operation(
 *      method="GET",
 *      summary="关注&取消关注指店",
 *      notes="关注&取消关注指店",
 *      type="Member",
 *      nickname="AttentionVstore",
 *      @SWG\Parameter(
 *          name="vstore_id",
 *          description="指店ID",
 *          type="integer",
 *          paramType="query",
 *          required=true
 *      ),
 *      @SWG\ResponseMessage(code=401, message="尚未登录。"),
 *      @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *      @SWG\ResponseMessage(code=200, message="用户模型")
 *  )
 * )
 */
Route::get('vstore/attention', [
    'as' => 'AttentionVstore',
    'before' => 'auth',
    'uses' => 'VstoreController@attentionVstore'
]);

/**
 * @SWG\Api(
 *  path="/vstore/goods/list",
 *  @SWG\Operation(
 *      method="GET",
 *      summary="指店产品列表",
 *      notes="未传指店ID时默认为登录者所开的指店，最终得到指店对应的门店的商品列表",
 *      type="Goods",
 *      nickname="VstoreGoodsList",
 *      @SWG\Parameter(
 *          name="vstore_id",
 *          description="指店ID",
 *          type="integer",
 *          paramType="query",
 *          required=true
 *      ),
 *      @SWG\Parameter(
 *          name="goods_class",
 *          description="商品类别[Same-门店同款|Inner-内购商品]",
 *          type="string",
 *          paramType="query",
 *          enum="['Same','Inner']",
 *          required=false,
 *          defaultValue="Same",
 *      ),
 *      @SWG\Parameter(
 *          name="goods_type_id",
 *          description="商品类别ID",
 *          type="integer",
 *          paramType="query",
 *          required=false
 *      ),
 *      @SWG\Parameter(
 *          name="start_price",
 *          description="起始价格",
 *          type="integer",
 *          paramType="query",
 *          required=false
 *      ),
 *      @SWG\Parameter(
 *          name="end_price",
 *          description="结束价格",
 *          type="integer",
 *          paramType="query",
 *          required=false
 *      ),
 *      @SWG\Parameter(
 *          name="number",
 *          description="商品型号模糊查询",
 *          type="string",
 *          paramType="query",
 *          required=false
 *      ),
 *      @SWG\Parameter(
 *          name="name",
 *          description="商品名称模糊查询",
 *          type="string",
 *          paramType="query",
 *          required=false
 *      ),
 *      @SWG\Parameter(
 *          name="page",
 *          description="页码",
 *          required=false,
 *          type="integer",
 *          paramType="query",
 *          defaultValue="1"
 *      ),
 *      @SWG\Parameter(
 *          name="limit",
 *          description="每页数",
 *          required=false,
 *          type="integer",
 *          paramType="query",
 *          defaultValue="10"
 *      ),
 *      @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *      @SWG\ResponseMessage(code=200, message="门店商品模型")
 *  )
 * )
 */
Route::get('vstore/goods/list', [
    'as' => 'VstoreGoodsList',
    'uses' => 'VstoreController@goodsList'
]);

/**
 * @SWG\Api(
 *  path="/vstore/friend-vstore/list",
 *  @SWG\Operation(
 *      method="GET",
 *      summary="好友指店列表",
 *      notes="和好友必须是互相关注的，并且成功开了指店的好友指店",
 *      type="Vstore",
 *      nickname="MyFriendsVstoreList",
 *      @SWG\Parameter(
 *          name="page",
 *          description="页码",
 *          required=false,
 *          type="integer",
 *          paramType="query",
 *          defaultValue="1"
 *      ),
 *      @SWG\Parameter(
 *          name="limit",
 *          description="每页数",
 *          required=false,
 *          type="integer",
 *          paramType="query",
 *          defaultValue="10"
 *      ),
 *      @SWG\ResponseMessage(code=402, message="表单验证失败。"),
 *      @SWG\ResponseMessage(code=200, message="门店商品模型")
 *  )
 * )
 */
Route::get('vstore/friend-vstore/list', [
    'as' => 'MyFriendsVstoreList',
    'before' => 'auth',
    'uses' => 'VstoreController@myFriendsVstoreList'
]);


/**
 * @SWG\Api(
 *  path="/vstore/list",
 *  @SWG\Operation(
 *      method="GET",
 *      summary="获取指店列表",
 *      notes="获取指店列表",
 *      type="Vstore",
 *      nickname="GetVstoreList",
 *      @SWG\Parameters(
 *          @SWG\Parameter(
 *              name="name",
 *              description="指定名称",
 *              type="string",
 *              paramType="query"
 *          ),
 *          @SWG\Parameter(
 *              name="page",
 *              description="页码",
 *              required=false,
 *              type="integer",
 *              paramType="query",
 *              defaultValue="1"
 *          ),
 *          @SWG\Parameter(
 *              name="limit",
 *              description="每页数",
 *              required=false,
 *              type="integer",
 *              paramType="query",
 *              defaultValue="10"
 *          ),
 *      ),
 *      @SWG\ResponseMessage(code=402, message="提交参数错误提示"),
 *      @SWG\ResponseMessage(code=200, message="指店模型")
 *  )
 * )
 */
Route::get('vstore/list', [
    'as' => 'GetVstoreList',
    'uses' => 'VstoreController@getList'
]);


/**
 * 获取指店的活动列表
 */
Route::get('vstore/goods_list', [
    'as' => 'GetVstoreActivityGoods',
    'uses' => 'ActivityController@getVstoreActivityGoods'
]);