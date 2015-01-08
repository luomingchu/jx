<?php

/**
 * 活动模块
 */
class ActivityController extends BaseController
{

    /**
     * 获取指店首页活动
     */
    public function getIndexList()
    {
        $vstore_id = Input::get('vstore_id');

        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id'
            ]
        ], [
            'vstore_id.required' => '指店不能为空',
            'vstore_id.exists' => '指店不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 指店
        $vstore = Vstore::find($vstore_id);

        if (! $vstore->status == Vstore::STATUS_OPEN) {
            return Response::make('指店状态不正常', 402);
        }

        // 指店对应组织区域
        /*
         * $vstore_group = $vstore->store->group; if (is_null($vstore_group)) { return Response::make('门店没有设置区域组织', 402); } $vstore_group_id = $vstore_group->id;
         */

        // 内购活动
        $inner_purchase_activity = $this->getActivity(Activity::TYPE_INNER_PURCHASE, $vstore->store->id);

        if (! empty($inner_purchase_activity)) {
            $inner_purchase_activity = StoreActivity::with('body')->find($inner_purchase_activity->id);
            $inner_purchase_activity->goods = $inner_purchase_activity->goods()->orderBy('id', 'asc')->take(10)->get();
        } else {
            $inner_purchase_activity = null;
        }

        // 预售活动
        /*
         * $presell_activity = $this->getActivity(Activity::TYPE_PRESELL, $vstore_group_id); if (! empty($presell_activity)) { $presell_activity = Activity::with('body')->find($presell_activity->id); } else { $presell_activity = null; }
         */

        return compact('inner_purchase_activity');
    }

    /**
     * 获取正在进行的活动
     *
     * @param
     *            string body_type 活动类型
     * @param
     *            string vstore_group_id 活动组织id
     */
    public function getActivity($body_type, $store_id)
    {

        // 当前时间
        $now_time = date('Y-m-d H:i:s');

        // 内购活动
        $activity = StoreActivity::where('body_type', $body_type)->where('status', Activity::STATUS_OPEN)
            ->where('deleted', null)
            ->where('store_id', $store_id)
            ->where('start_datetime', '<', $now_time)
            ->where('end_datetime', '>', $now_time)
            ->latest()
            ->first();

        // 没有活动返回空
        if (is_null($activity)) {
            return '';
        } else {
            return $activity;
        }

        /*
         * // 指店对应区域匹配活动地区标识 $matchFlag = false; // 活动遍历 foreach ($activities as $activity) { // 活动投放地区 $groups = $activity->groups()->get(); foreach ($groups as $group) { // 判断指店对应门店区域是否在活动投放区域 if ($group->id == $vstore_group_id) { $matchFlag = true; break; } // 指店对应门店区域的父区域为投放区域 $rs = Group::whereId($vstore_group_id)->where('parent_path', 'like', "%:" . $group->id . ":%")->get(); // 投放区域不为空 if (! ($rs->isEmpty())) { $matchFlag = true; break; } } if ($matchFlag) { break; } } // 返回结果 if ($matchFlag) { return $activity; } else { return ''; }
         */
    }


    /**
     * 获取指定指店的活动列表
     */
    public function getList()
    {
        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id'
            ]
        ], [
            'vstore_id.required' => '指店不能为空',
            'vstore_id.exists' => '指店不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取指店信息
        $vstore = Vstore::find(Input::get('vstore_id'));

        return StoreActivity::where('status', StoreActivity::STATUS_OPEN)->where('deleted', null)->where('end_datetime', '>', date('Y-m-d H:i:s'))->where('store_id', $vstore->store_id)->oldest()->get();
    }


    /**
     * 获取指定活动的商品列表
     */
    public function getActivityGoods()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'activity_id' => [
                    'required',
                    'exists:' . Config::get('database.connections.own.database') . '.store_activities,id'
                ],
                'category_id' => [
                    'exists:'. Config::get('database.connections.own.database') . '.goods_category,id'
                ],
                'start_price' => [
                    'numeric'
                ],
                'end_price' => [
                    'numeric'
                ],
                'page' => [
                    'integer',
                    'min:0'
                ],
                'limit' => [
                    'integer',
                    'between:1,200'
                ]
            ],
            [
                'activity_id.required' => '活动不能为空',
                'activity_id.exists' => '查询的活动不存在',
                'category_id.exists' => '商品类别不存在',
                'start_price.numeric' => '开始价格格式错误',
                'end_price.numeric' => '结束价格格式错误',
                'page.integer' => '页码格式错误',
                'page.page' => '页码格式错误',
                'limit.integer' => '每页条目数格式错误',
                'limit.between' => '每页条目数只能在1~200之间',
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取此活动的所有商品
        $activity_goods = StoreActivitiesGoods::where('store_activity_id', Input::get('activity_id'))->lists('goods_id');

        if (empty($activity_goods)) {
            return [];
        }

        // 过滤商品类别
        if (Input::has('category_id')) {
            // 获取指定分类的所有子级分类
            $category = GoodsCategory::find(Input::get('category_id'));
            $childrenCategories = $category->ChildNodes()->get();
            $categories[] = Input::get('category_id');
            if (! $childrenCategories->isEmpty()) {
                $categories = array_merge($categories, $childrenCategories->modelKeys());
            }
            // 获取在这些分类的商品列表
            $goods_ids = CategoryGoods::whereIn('goods_category_id', $categories)->lists('goods_id');
            if (empty($goods_ids)) {
                return [];
            }
            $activity_goods = array_intersect($activity_goods, $goods_ids);

            // 判断是否有符合条件的商品ID
            if (empty($activity_goods)) {
                return [];
            }
        }

        // 获取商品列表
        $list = Goods::whereIn('id', $activity_goods)->latest();

        // 过滤价格
        if (Input::has('start_price') || Input::has('end_price')) {
            $start_price = Input::get('start_price', 0);
            $end_price = Input::get('end_price', 9999999999);
            $price = [$start_price, $end_price];
            sort($price);
            $list->whereBetween('price', $price);
        }

        // 过滤商品名称
        if (Input::has('goods_name')) {
            $list->where('name', 'like', '%'.Input::get('goods_name').'%');
        }

        return $list->paginate(Input::get('limit', 15))->getItems();
    }


    /**
     * 获取指店所有的活动商品
     */
    public function  getVstoreActivityGoods()
    {
        $validator = Validator::make(Input::all(), [
            'vstore_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
        ], [
            'vstore_id.required' => '指店不存在！',
            'vstore_id.exists' => '指店不存在！'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 完全没有原型和页面，所以就抓该企业的所有指店
        $vstore = Vstore::with('member', 'store')->find(Input::get('vstore_id'));

        if (Input::has('store_activity_id')) {
            $store_activity = [Input::get('store_activity_id')];
        } else {
            $store_activity = StoreActivity::where('store_id', $vstore->store->id)->where('status', StoreActivity::STATUS_OPEN)->where('end_datetime', '>', date('Y-m-d H:i:s'))->lists('id');
        }
        if (empty($store_activity)) {
            return [];
        } else {
            return StoreActivitiesGoods::whereIn('store_activity_id', $store_activity)->paginate(6)->getItems();
        }
    }
}