<?php

/**
 * 商品控制器
 */
class GoodsController extends BaseController
{

    /**
     * 商品频道
     */
    public function getChannel()
    {
        return GoodsChannel::all();
    }

    /**
     * 获取商品详细信息，等加入购物车后需传指店ID
     */
    public function getInfo()
    {
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods,id,deleted_at,NULL'
            ]
        ], [
            'goods_id.required' => '商品ID不能为空！',
            'goods_id.exists' => '商品不存在或已被删除'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $info = Goods::with('goodsAttributes')->find(Input::get('goods_id'));
        return $info;
    }

    /**
     * 获取商品产品介绍web页面
     */
    public function getDetailView()
    {
        $validator = Validator::make(Input::all(), [
            'goods_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.goods,id,deleted_at,NULL'
        ], [
            'goods_id.required' => '商品ID不能为空！',
            'goods_id.exists' => '商品不存在或已被删除'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $info = Goods::find(Input::get('goods_id'));

        return View::make('goods.detail')->with(compact('info'));
    }

    /**
     * 获取商品属性参数web页面
     */
    public function getParameterView()
    {
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods,id,deleted_at,NULL'
            ]
        ], [
            'goods_id.required' => '商品ID不能为空！',
            'goods_id.exists' => '商品不存在或已被删除'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $info = Goods::find(Input::get('goods_id'));

        return View::make('goods.parameter')->with(compact('info'));
    }

    /**
     * 更新商品规格库存索引
     */
    public function updateGoodsIndex()
    {
        set_time_limit(0);

        $list = GoodsSku::paginate(50);
        foreach ($list as $sku) {
            // 获取商品详情
            $goods_info = Goods::find($sku->goods_id);
            if (! empty($goods_info)) {
                // 获取商品类别信息
                $goods_type = GoodsTypeAttribute::where('goods_type_id', $goods_info->goods_type_id)->orderBy('sort_order', 'asc')->get();
                $sku_index = [];
                foreach ($sku->sku_key as $sk => $sv) {
                    $sku_index[] = GoodsAttribute::where('goods_id', $goods_info->id)->where('goods_type_attribute_id', $goods_type->get($sk)->id)
                        ->where('name', $sv)
                        ->pluck('id');
                }
                $sku->sku_index = implode(':', $sku_index);
                $sku->save();
            }
        }

        echo 'success';
    }
}