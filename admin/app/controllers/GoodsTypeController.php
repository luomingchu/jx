<?php

/**
 * 商品类别控制器
 */
class GoodsTypeController extends BaseController
{

    /**
     * 获取类别列表
     */
    public function getList()
    {
        $list = GoodsType::latest()->paginate(Input::get('limit', 15));
        return View::make('goods_type.list')->with(compact('list'));
    }

    /**
     * 保存商品类别信息
     */
    public function postSave()
    {
        $goods_type_id = Input::get('goods_type_id');

        $validator = Validator::make(Input::all(), [
            'name' => [
                'required',
                "unique:goods_type,name,{$goods_type_id}"
            ],
            'attributes' => [
                'required_without:goods_type_id'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $goods_type = GoodsType::findOrNew(Input::get('goods_type_id', 0));
        $goods_type->name = Input::get('name');
        $goods_type->save();

        // 保存列表属性
        if (Input::has('attributes')) {
            // 获取类别属性表
            $attributes = array_unique(array_filter(explode("\r\n", Input::get('attributes'))));
            foreach ($attributes as $i => $attr) {
                $goods_type_attribute = new GoodsTypeAttribute();
                $goods_type_attribute->goodsType()->associate($goods_type);
                $goods_type_attribute->name = $attr;
                $goods_type_attribute->sort_order = $i;
                $goods_type_attribute->save();
            }
        }
        return 'success';
    }

    /**
     * 切换商品类别状态
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(Input::all(), [
            'goods_type_id' => [
                'required',
                'exists:goods_type,id'
            ],
            'status' => [
                'required',
                'in:' . GoodsType::STATUS_OPEN . ',' . GoodsType::STATUS_CLOSE
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $goods_type = GoodsType::find(Input::get('goods_type_id'));
        $goods_type->status = Input::get('status') == GoodsType::STATUS_CLOSE ? GoodsType::STATUS_OPEN : GoodsType::STATUS_CLOSE;
        $goods_type->save();
        return 'success';
    }

    /**
     * 获取类别属性列表
     */
    public function getAttrList()
    {
        $list = [];
        if (Input::has('goods_type_id')) {
            $list = GoodsTypeAttribute::where('goods_type_id', Input::get('goods_type_id'))->orderBy('sort_order', 'asc')->get();
        }
        $types = GoodsType::all();
        ! $types->isEmpty() && $types = $types->keyBy('id');
        return View::make('goods_type.attr_list')->with(compact('list', 'types'));
    }

    /**
     * 保存类别属性
     */
    public function postSaveAttr()
    {
        $goods_type_attribute_id = Input::get('goods_type_attribute_id');
        $goods_type_id = Input::get('goods_type_id');
        $validator = Validator::make(Input::all(), [
            'goods_type_id' => [
                'required',
                'exists:goods_type,id'
            ],
            'name' => [
                'required',
                "unique:goods_type_attributes,name,{$goods_type_attribute_id},id,goods_type_id,{$goods_type_id}"
            ],
            'sort_order' => [
                'integer',
                'min:0'
            ]
        ], [
            'name.required' => [
                '属性名称不能为空'
            ],
            'name.unique' => [
                '在此商品类别的属性名称不能重复'
            ],
            'sort_order.integer' => [
                '属性排序号，只能为整数'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $attribute = GoodsTypeAttribute::FindOrNew(Input::get('goods_type_attribute_id', 0));

        // 获取排序号
        $sort_order = Input::get('sort_order', GoodsTypeAttribute::where('goods_type_id', Input::get('goods_type_id'))->count() + 1);

        // 检查是否有相同的排序号
        $sort_order_count = GoodsTypeAttribute::where('goods_type_id', Input::get('goods_type_id'))->where('sort_order', $sort_order);
        if (Input::has('goods_type_attribute_id')) {
            $sort_order_count->where('id', '<>', Input::get('goods_type_attribute_id'));
        }
        if ($sort_order_count->count() > 0) {
            return Response::make('在此商品类别的属性排序号不能重复', 402);
        }

        $attribute->name = Input::get('name');
        $attribute->sort_order = $sort_order;
        $attribute->goods_type_id = $goods_type_id;
        $attribute->save();
        return 'success';
    }

    /**
     * 删除类别属性
     */
    public function postDeleteAttr()
    {
        $validator = Validator::make(Input::all(), [
            'goods_type_attribute_id' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        GoodsTypeAttribute::find(Input::get('goods_type_attribute_id'))->delete();
        return 'success';
    }

    /**
     * 删除商品类别
     */
    public function postDeleteType()
    {
        $validator = Validator::make(Input::all(), [
            'goods_type_id' => [
                'required'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        GoodsType::find(Input::get('goods_type_id'))->delete();
        return 'success';
    }
}