<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * 指店控制器
 *
 * @author jois
 */
class VstoreController extends BaseController
{

    /**
     * 获取指定指店的详细信息
     */
    public function getInfo()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'vstore_id' => 'required|exists:vstores,id'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 返回指店模型
        return Vstore::with('enterprise', 'member')->whereEnterpriseId($this->enterprise_info->id)->find(Input::get('vstore_id'));
    }

    /**
     * 申请开店
     */
    public function applyVstore()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), array(
            'real_name' => 'required|real_name',
            'id_number' => 'required|id_number',
            'id_picture_id' => 'required|exists:user_files,id|user_file_mime:/^image\//i'
        ), array(
            'real_name.required' => '真实姓名不能为空',
            'real_name.real_name' => '真实姓名只能是2-4个字的汉字',
            'id_number.required' => '身份证号码不能为空',
            'id_number.id_number' => '身份证号码格式错误',
            'id_picture_id.required' => '持证照图片不能为空',
            'id_picture_id.exists' => '持证照图片ID不存在',
            'id_picture_id.user_file_mime' => '持证照图片格式不正确'
        ));
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 申请开店，状态为审核[当企业审核不通过时可重复申请]
        $temp = Vstore::whereMemberId(Auth::user()->id)->whereEnterpriseId($this->enterprise_id)->first();
        if (! is_null($temp) && $temp->status != Vstore::STATUS_ENTERPRISE_AUDITERROR) {
            switch ($temp->status) {
                case Vstore::STATUS_CLOSE:
                    // TODO:已经关闭的指店是否可以重新申请？
                    return Response::make('您的店铺已经关闭', 402);
                    break;
                case Vstore::STATUS_OPEN:
                    return Response::make('您的店铺已经开通', 402);
                    break;
                case Vstore::STATUS_ENTERPRISE_AUDITED:
                    return Response::make('您的店铺已经审核通过了，无需重复申请');
                    break;
                case Vstore::STATUS_ENTERPRISE_AUDITING:
                    return Response::make('您的店铺企业正则审核中，请耐心等待');
                    break;
                case Vstore::STATUS_MEMBER_GETED:
                    return Response::make('您的店铺已经申请并成功领取，请填写店铺名称及图片完成开店');
                    break;
            }
        }

        // 保存数据
        $member = Auth::user();
        $vstore = is_null($temp) ? new Vstore() : $temp;
        $vstore->member()->associate($member);
        $vstore->enterprise()->associate($this->enterprise_info);
        $vstore->name = trim(Input::get('name'));
        $vstore->status = Vstore::STATUS_ENTERPRISE_AUDITING;
        $vstore->save();

        $member->real_name = trim(Input::get('real_name'));
        $member->id_number = Input::get('id_number');
        $member->id_picture_id = Input::get('id_picture_id');
        $member->save();

        return Vstore::with('member')->find($vstore->id);
    }

    /**
     * 领取店铺并最终开店陈功
     */
    public function postOpenVstore()
    {
        // 验证输入
        $vstore = Vstore::whereMemberId(Auth::id())->whereStatus(Vstore::STATUS_ENTERPRISE_AUDITED)->first();
        if (is_null($vstore)) {
            return Response::make('您的指店不存在，或企业还未审核通过', 402);
        }

        // 更改状态为开店成功
        $vstore->status = Vstore::STATUS_OPEN;
        $vstore->save();

        return 'success';
    }

    /**
     * 指店产品列表，不传则默认登录用户的指店
     */
    public function goodsList()
    {
        if (Input::has('vstore_id')) {
            $vstore = Vstore::whereId(Input::get('vstore_id'))->whereStatus(Vstore::STATUS_OPEN)->first();
        } elseif (Auth::check()) {
            $vstore = Vstore::whereMemberId(Auth::user()->info->attention_vstore_id)->whereStatus(Vstore::STATUS_OPEN)->first();
        }

        if (is_null($vstore)) {
            return Response::make('指店不存在或尚未开通成功', 402);
        }

        $store = $vstore->store;

        if (! is_null($vstore)) {
            $validator = Validator::make(Input::all(), [
                'vstore_id' => 'integer',
                'goods_class' => 'required|in:Same,Inner',
                'goods_type_id' => 'integer',
                'start_price' => 'numeric|min:1',
                'end_price' => 'numeric',
                'limit' => 'integer|between:1,200',
                'page' => 'integer|min:1'
            ], [
                'vstore_id.integer' => '指店参数必须为数字类型',
                'goods_class.in' => '商品类别参数必须在Same和Inner间选择',
                'goods_type_id.integer' => '商品类别参数必须为数字类型',
                'start_price.numeric' => '起始价格必须为数字类型',
                'start_price.min' => '起始价格最小值为1，请填写大于1的整数',
                'end_price.numeric' => '结束价格必须为数字类型',
                'limit.integer' => '每页记录数必须为整数',
                'limit.between' => '每页记录数必须在1-200之间',
                'page.integer' => '页数必须为整数',
                'page.min' => '页数必须大于0'
            ]);

            if ($validator->fails()) {
                return Response::make($validator->messages()->first(), 402);
            }

            // 得到具体门店
            $store_id = $vstore->store_id;

            // 获取商品类型
            $goods_class = Input::get('goods_class', 'Same');

            // 设置要查询的价格区间
            $price = [
                Input::get('start_price', 0),
                Input::get('end_price', 100000000)
            ];
            sort($price);

            // 活动商品ID
            $now_time = date('Y-m-d H:i:s');
            $store_activity_ids = StoreActivity::whereStoreId($store->id)->whereStatus(StoreActivity::STATUS_OPEN)
                ->where('start_datetime', '<', $now_time)
                ->where('end_datetime', '>', $now_time)
                ->where('deleted', null)
                ->lists('id');
            if (empty($store_activity_ids)) {
                $goods_ids = [];
            } else {
                // 一个商品在一家门店中只能做一个活动
                $store_activity_goods_ids = StoreActivitiesGoods::whereIn('store_activity_id', $store_activity_ids)->lists('goods_id');
                $goods_ids = empty($store_activity_goods_ids) ? [] : $store_activity_goods_ids;
            }

            $goods = Goods::with('channel')->whereStoreId($store_id)->whereStatus(Goods::STATUS_OPEN);

            // 商品类别，大类别
            if (Input::has('goods_type_id')) {
                $goods->whereGoodsTypeId(Input::get('goods_type_id'));
            }
            // 商品型号
            if (Input::has('number')) {
                $goods->where('number', 'like', '%' . Input::get('number') . '%');
            }
            // 商品名称
            if (Input::has('name')) {
                $goods->where('name', 'like', '%' . Input::get('name') . '%');
            }
            // 商品类别
            if ($goods_class == 'Inner') {
                // 重新获取符合活动价格区间的活动商品
                ! empty($goods_ids) && $goods_ids = StoreActivitiesGoods::whereIn('store_activity_id', $store_activity_ids)->whereBetween('discount_price', $price)->lists('goods_id');
                if (empty($goods_ids)) {
                    // return Response::make('没有做活动的商品', 402);
                    return '';
                }
                $goods->whereIn('id', $goods_ids);
            } else {
                // 默认门店同款
                if (! empty($goods_ids)) {
                    // 价格区间
                    $goods->whereBetween('price', $price);

                    $goods->whereNotIn('id', $goods_ids);
                }
            }

            $data = $goods->latest()
                ->paginate(Input::get('limit', 10))
                ->getCollection();

            return $data;
        }
        return Response::make('产品为空，请传递指店参数或者请关注某一个指店', 402);
    }
}