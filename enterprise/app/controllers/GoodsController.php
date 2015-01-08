<?php

/**
 * 企业商品控制器
 */
class GoodsController extends BaseController
{

    /**
     * 新增&编辑商品
     */
    public function edit($id = 0)
    {
        // 获得第一级商品分类
        $category = GoodsCategory::e()->whereParentPath('')->get();

        // 获取商品类别
        $goods_type_ids = EnterpriseGoodsType::lists('goods_type_id');
        $goods_type = [];
        if (! empty($goods_type_ids)) {
            $goods_type = GoodsType::where('status', GoodsType::STATUS_OPEN)->whereIn('id', $goods_type_ids)->get();
        }

        // 获取修改的商品分类信息
        $data = Goods::with('categorys', 'pictures')->find($id);

        // 如果是编辑，则找出这个商品对应的分类，并且进行每行循环，每行中包括第一级的到此最后节点的遍历
        $cate_data = array();
        $cate_id = array();
        if (! is_null($data)) {
            $cate = CategoryGoods::whereGoodsId($id)->lists('goods_category_id');
            foreach ($cate as $key => $item) {
                $pid = GoodsCategory::find($item);
                $path = $pid->path;
                $path_ids = array_filter(explode(':', $path));
                foreach ($path_ids as $key2 => $dd) {
                    // 找出这个当前级的所有分类
                    $parent_path = GoodsCategory::find($dd)->parent_path;
                    $cate_data[$key][$key2] = GoodsCategory::whereParentPath($parent_path)->get()->toArray(); // ->toArray()
                    $cate_id[$key][$key2] = $dd;
                }
            }
        }
        // 返回视图
        return View::make('goods.edit')->withData($data)
            ->withCategory($category)
            ->withCateData($cate_data)
            ->withGoodsType($goods_type)
            ->withCateId($cate_id);
    }

    /**
     * 商品保存
     */
    public function postSave()
    {
        // 验证输入
        $input = Input::all();
        $input['category'] = array_filter($input['category']);

        $validator = Validator::make($input, array(
            'id' => 'exists:goods,id',
            'number' => [
                'required',
                'unique:goods,number,' . Input::get('id').',id,deleted_at,NULL,enterprise_id,'.$this->enterprise_info->id
            ],
            'name' => 'required',
            'goods_type_id' => [
                'required',
                'exists:goods_type,id'
            ],
            'sku_price' => [
                'required'
            ],
            'sku_attr' => [
                'required'
            ],
            'brokerage_ratio' => [
                'numeric',
                'max:100'
            ],
            'category' => 'required',
            'market_price' => 'required|min:0|numeric',
            'description' => 'required',
            'parameter' => 'required',
            'pictures' => 'required'
        ), array(
            'number.required' => '商品型号不能为空！',
            'name.required' => '商品名称不能为空！',
            'number.unique' => '商品型号已经存在，不能重复添加！',
            'category.required' => '商品分类不能为空！',
            'market_price.required' => '商品市场价不能为空！',
            'market_price.min' => '商品市场价不能小于0！',
            'market_price.numeric' => '商品市场价必须是一个数字！',
            'description.required' => '商品详情不能为空！',
            'parameter.required' => '商品参数不能为为空',
            'pictures.required' => '商品图片不能为为空',
            'goods_type_id.required' => '所属商品类别不能为空',
            'sku_price.required' => '商品规格价格不能为空',
            'sku_attr.required' => '商品规格不能为空',
            'brokerage_ratio.numeric' => '佣金比率只能为数字字符',
            'brokerage_ratio.max' => '佣金比率不能大于100'
        ));

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取分类最终值
        $category = array_flatten(array_unique(array_filter(Input::get('category'))));
        // 去除分类中有子类的父类
        $new_cids = $category;
        foreach ($category as $key1 => $cid1) {
            $cids = GoodsCategory::find($cid1)->childNode()->lists('id');
            foreach ($category as $key2 => $cid2) {
                if (in_array($cid2, $cids)) {
                    unset($new_cids[$key1]);
                }
            }
        }

        // 取得要保存的对象。
        $enterprise_goods = Goods::findOrNew(Input::get('id', 0));

        $sku_price = Input::get('sku_price');
        $sku_attr = Input::get('sku_attr');

        // 判断佣金比率修改是否已经超出一个月
        if ($enterprise_goods->brokerage_ratio != Input::get('brokerage_ratio')) {
            if ($enterprise_goods->status == Goods::STATUS_OPEN) {
                return Response::make('此商品已经上架，上架商品不能修改佣金比率！', 402);
            } elseif (! empty($enterprise_goods->brokerage_ratio_updated_time) && strtotime($enterprise_goods->brokerage_ratio_updated_time) > strtotime('-1 month')) {
                return Response::make('佣金比率只能一个月修改一次，最后修改时间为：' . $enterprise_goods->brokerage_ratio_updated_time . '！', 402);
            }
        }

        // 保存数据。
        $enterprise_goods->number = trim(Input::get('number'));
        $enterprise_goods->name = trim(Input::get('name'));
        $enterprise_goods->market_price = trim(Input::get('market_price'));
        $enterprise_goods->price = min($sku_price);
        $enterprise_goods->description = Input::get('description');
        $enterprise_goods->parameter = Input::get('parameter');
        $enterprise_goods->goods_type_id = Input::get('goods_type_id');
        $enterprise_goods->goods_attributes = Input::get("sku_attr");
        $enterprise_goods->brokerage_ratio = Input::get('brokerage_ratio');
        $enterprise_goods->status = Input::get('status');
        $enterprise_goods->brokerage_ratio_updated_time = new \Carbon\Carbon();
        $enterprise_goods->save();

        // 保存商品分类
        $enterprise_goods->categorys()->sync($new_cids);

        // 保存商品图片
        $pictures = Input::get('pictures');
        $enterprise_goods->pictures()->sync($pictures);

        // 保存商品规格信息
        // 获取对应商品类别下的属性
        $goods_type_attribute = GoodsTypeAttribute::where('goods_type_id', Input::get('goods_type_id'))->orderBy('sort_order', 'asc')->lists('id');

        $sku_id = [];
        foreach ($sku_price as $k => $v) {
            // 按类别属性顺序生成库存key
            $attr = [];
            $index = [];
            foreach ($goods_type_attribute as $gta) {
                $attr[] = $sku_attr[$k][$gta];
                $index[] = GoodsAttribute::where('goods_id', $enterprise_goods->id)->where('goods_type_attribute_id', $gta)
                    ->where('name', $sku_attr[$k][$gta])
                    ->pluck('id');
            }
            // 当都不为空时才设置库存
            if (! empty($v) && count($attr) == count($goods_type_attribute)) {
                $sku_key = implode(':', $attr);
                $sku_index = implode(':', $index);
                // 如果原来已有库存信息则进行修改，没有则进行添加
                $sku_info = GoodsSku::where('goods_id', $enterprise_goods->id)->where('sku_index', $sku_index)->first();
                if (! empty($sku_info)) {
                    $sku_id[] = $sku_info->id;
                    $sku_info->price = $sku_price[$k];
                    $sku_info->stock = Input::get("sku_stock.{$k}", 0);
                    $sku_info->save();
                } else {
                    $sku_info = new GoodsSku();
                    $sku_info->goods()->associate($enterprise_goods);
                    $sku_info->sku_key = $sku_key;
                    $sku_info->sku_index = $sku_index;
                    $sku_info->price = $sku_price[$k];
                    $sku_info->stock = Input::get("sku_stock.{$k}", 0);
                    $sku_info->save();
                    $sku_id[] = $sku_info->id;
                }
            }
        }
        // 删除原来多余的库存信息
        if (! empty($sku_id)) {
            $sku_info = GoodsSku::where('goods_id', $enterprise_goods->id)->whereNotIn('id', $sku_id)->get();
            foreach ($sku_info as $sku) {
                $sku->delete();
            }
        }

        return $enterprise_goods;
    }

    /**
     * 上架商品列表
     */
    public function saleGoodsList()
    {
        // 返回视图
        return View::make('goods.list')->with($this->getList(Goods::STATUS_OPEN));
    }

    /**
     * 下架商品列表
     */
    public function repertoryGoodsList()
    {
        // 返回视图
        return View::make('goods.repertory')->with($this->getList(Goods::STATUS_CLOSE));
    }

    /**
     * 获取商品列表
     */
    protected function getList($status)
    {
        // 获得第一级商品分类
        $category = GoodsCategory::e()->whereParentPath('')->get();

        // 根据参数获取商品列表信息
        $goods_list = Goods::with('categorys')->where('status', $status);

        if (Input::has('category_id')) {
            $category_ids = array_filter(Input::get('category_id'));
            $word = end($category_ids);

            if ($word) {
                // 取得这个分类及旗下所有分类
                $child_nodes = GoodsCategory::find($word)->childNodes(true)->lists('id');
                // 取得这些分类下的所有商品
                $goods_list->whereHas('categorys', function ($q) use($child_nodes)
                {
                    $q->whereIn('goods_category_id', $child_nodes);
                });
            }
        }
        if (Input::has('name')) {
            $goods_list->where(function ($q)
            {
                $q->where('number', 'like', "%" . Input::get('name') . "%")
                    ->orWhere('name', 'like', "%" . Input::get('name') . "%");
            });
        }
        if (Input::has('goods_type_id')) {
            $goods_list->where('goods_type_id', Input::get('goods_type_id'));
        }

        // 按创建时间排序
        if (Input::has('create') && in_array(Input::get('create'), [
            'desc',
            'asc'
        ])) {
            $goods_list->orderBy('created_at', Input::get('create'));
        }
        // 按销量排序
        if (Input::has('quantity') && in_array(Input::get('quantity'), [
            'desc',
            'asc'
        ])) {
            $goods_list->orderBy('trade_quantity', Input::get('quantity'));
        }
        $data = $goods_list->latest()->paginate(10);

        return compact('data', 'category');
    }

    /**
     * 获取库存配置页面
     */
    public function getSkuView()
    {
        $attributes = GoodsTypeAttribute::where('goods_type_id', Input::get('goods_type_id'))->orderBy('sort_order', 'asc')->get();
        if (Input::has('goods_id')) {
            $sku_info = GoodsSku::where('goods_id', Input::get('goods_id'))->get();
        }
        return View::make('goods.sku')->with(compact('attributes', 'sku_info'));
    }

    /**
     * 异步检验产品型号是否重复
     */
    public function ajaxCheckNumber()
    {
        $number = Goods::where('number', Input::get('number'));
        if (Input::has('goods_id')) {
            $number->where('id', '<>', Input::get('goods_id'));
        }
        if ($number->count() > 0) {
            return Response::make('系统已存在此商品型号', 402);
        }
        return 'success';
    }

    /**
     * 商品上下架
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required'
            ],
            'status' => [
                'required',
                'in:' . Goods::STATUS_CLOSE . ',' . Goods::STATUS_OPEN
            ]
        ], [
            'goods_id.required' => '请选择要操作的商品',
            'status.required' => '请选择商品的操作类型',
            'status.in' => '设置商品状态信息错误'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        Goods::whereIn('id', (array) Input::get('goods_id'))->update([
            'status' => Input::get('status')
        ]);

        return 'success';
    }

    /**
     * 删除商品
     */
    public function postDelete()
    {
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messges()->first(), 402);
        }

        $goods_id = (array) Input::get('goods_id');
        // 判断是否被引用且在销售中
        $goods_list = Goods::e()->whereIn('id', $goods_id)->get();
        if ($goods_list->isEmpty()) {
            return Response::make('您没有相关商品信息！', 402);
        }

        foreach ($goods_list as $goods) {
            $goods->delete();
        }
        return 'success';
    }

    /**
     * Ajax方式获取商品列表
     */
    public function getListAjax()
    {
        if (Input::has('start_date')) {
            $start = Input::get('start_date') . " " . Input::get('start_time', '00:00') . ':00';
        } else {
            $start = "2000-1-1 00:00:00";
        }
        if (Input::has('end_date')) {
            $end = Input::get('end_date') . " " . Input::get('end_time', '23:59') . ":59";
        } else {
            $end = "2050-12-31 23:59:59";
        }
        $datetime = compact('start', 'end');
        $activity_list = Activity::where('body_type', Activity::TYPE_INNER_PURCHASE)->where(function($q) use ($datetime) {
            $q->whereBetween('start_datetime', $datetime)->orWhereBetween('end_datetime', $datetime);
        })->get();
        $selected_groups = [];
        // 获取选择区域所有上级及其区域
        foreach (Input::get('groups') as $group) {
            $groupInfo = Group::find($group);
            $selected_groups = array_unique(array_merge($selected_groups, array_filter(explode(':', $groupInfo->path))));
            // 其所有下级区域
            $child_groups = $groupInfo->ChildNodes()->get();
            if (! $child_groups->isEmpty()) {
                foreach ($child_groups as $child) {
                    $selected_groups = array_unique(array_merge($selected_groups, array_filter(explode(':', $child->path))));
                }
            }
        }
        $join_goods = [];
        // 如果有相关活动，则过滤相关区域的已参加的商品列表
        if (! $activity_list->isEmpty()) {
            foreach ($activity_list as $activity) {
                $intersect = array_intersect($activity->groups->fetch('id')->toArray(), $selected_groups);
                if (! empty($intersect)) {
                    $ag = $activity->goods;
                    $join_goods = array_merge($join_goods, $ag->fetch('enterprise_goods.id')->toArray());
                }
            }
        }

        // 取得数据模型。
        $goods_list = Goods::latest('id')->where('status', Goods::STATUS_OPEN);

        if (! empty($join_goods)) {
            $goods_list->whereNotIn('id', $join_goods);
        }

        // 处理筛选条件。
        if (Input::has('name')) {
            $goods_list->where('name', 'like', '%' . Input::get('name') . '%');
        }
        if (Input::has('number')) {
            $goods_list->where('number', Input::get('number'));
        }
        $category_id = Input::get('category_id');
        if (! empty($category_id)) {
            // 取得这个分类及旗下所有分类
            $child_nodes = GoodsCategory::find(Input::get('category_id'))->childNodes(true)->lists('id');
            // 取得这些分类下的所有商品
            $goods_list->whereHas('categorys', function ($q) use($child_nodes)
            {
                $q->whereIn('goods_category_id', $child_nodes);
            });
        }
        // 返回单页数据。
        $goods_list = $goods_list->paginate(Input::get('limit', 15))->getItems();
        $list = [];
        if (count($goods_list) > 0) {
            foreach ($goods_list as $goods) {
                $goods = $goods->toArray();
                $tmp = [];
                if ($goods['sku']) {
                    $sku = array_unique(array_fetch($goods['sku'], 'price'));
                    sort($sku);
                    $tmp[] = current($sku);
                    $tmp[] = end($sku);
                    $goods['price'] = $tmp;
                } else {
                    $goods['price'] = [];
                }
                $list[] = $goods;
            }
        }
        return $list;
    }

    /**
     * Ajax方式获取商品列表数
     */
    public function getListCountAjax()
    {
        if (Input::has('start_date')) {
            $start = Input::get('start_date') . " " . Input::get('start_time', '00:00') . ':00';
        } else {
            $start = "2000-1-1 00:00:00";
        }
        if (Input::has('end_date')) {
            $end = Input::get('end_date') . " " . Input::get('end_time', '23:59') . ":59";
        } else {
            $end = "2050-12-31 23:59:59";
        }
        $datetime = compact('start', 'end');
        $activity_list = Activity::where('body_type', Activity::TYPE_INNER_PURCHASE)->where(function($q) use ($datetime) {
            $q->whereBetween('start_datetime', $datetime)->orWhereBetween('end_datetime', $datetime);
        })->get();
        $selected_groups = [];
        // 获取选择区域所有上级及其区域
        foreach (Input::get('groups') as $group) {
            $groupInfo = Group::find($group);
            $selected_groups = array_unique(array_merge($selected_groups, array_filter(explode(':', $groupInfo->path))));
            // 其所有下级区域
            $child_groups = $groupInfo->ChildNodes()->get();
            if (! $child_groups->isEmpty()) {
                foreach ($child_groups as $child) {
                    $selected_groups = array_unique(array_merge($selected_groups, array_filter(explode(':', $child->path))));
                }
            }
        }
        $join_goods = [];
        // 如果有相关活动，则过滤相关区域的已参加的商品列表
        if (! $activity_list->isEmpty()) {
            foreach ($activity_list as $activity) {
                $intersect = array_intersect($activity->groups->fetch('id')->toArray(), $selected_groups);
                if (! empty($intersect)) {
                    $ag = $activity->goods;
                    $join_goods = array_merge($join_goods, $ag->fetch('enterprise_goods.id')->toArray());
                }
            }
        }

        // 取得数据模型。
        $goods_list = Goods::latest('id')->where('status', Goods::STATUS_OPEN);

        if (! empty($join_goods)) {
            $goods_list->whereNotIn('id', $join_goods);
        }

        // 处理筛选条件。
        if (Input::has('name')) {
            $goods_list->where('name', 'like', '%' . Input::get('name') . '%');
        }
        if (Input::has('number')) {
            $goods_list->where('number', Input::get('number'));
        }
        $category_id = Input::get('category_id');
        if (! empty($category_id)) {
            // 取得这个分类及旗下所有分类
            $child_nodes = GoodsCategory::find(Input::get('category_id'))->childNodes(true)->lists('id');
            // 取得这些分类下的所有商品
            $goods_list->whereHas('categorys', function ($q) use($child_nodes)
            {
                $q->whereIn('goods_category_id', $child_nodes);
            });
        }

        // 返回单页数据。
        return $goods_list->count();
    }


    /**
     * 获取商品列表
     */
    public function searchGoodsList()
    {
        // 取得数据模型。
        $goods_list = Goods::latest('id')->where('status', Goods::STATUS_OPEN);

        // 处理筛选条件。
        if (Input::has('name')) {
            $goods_list->where('name', 'like', '%' . Input::get('name') . '%');
        }
        if (Input::has('number')) {
            $goods_list->where('number', Input::get('number'));
        }
        $category_id = array_filter((array)Input::get('category_id'));
        if (! empty($category_id)) {
            $category_id = end($category_id);
            // 取得这个分类及旗下所有分类
            $child_nodes = GoodsCategory::find($category_id)->childNodes(true)->lists('id');
            // 取得这些分类下的所有商品
            $goods_list->whereHas('categorys', function ($q) use($child_nodes)
            {
                $q->whereIn('goods_category_id', $child_nodes);
            });
        }
        // 返回单页数据。
        $goods_list = $goods_list->paginate(Input::get('limit', 15));

        return View::make('goods.goods_list')->with(compact('goods_list'));
    }
}