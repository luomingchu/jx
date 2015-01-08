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
        $list = GoodsType::with('enterpriseGoodsTypes')->latest()
            ->whereStatus(GoodsType::STATUS_OPEN)
            ->paginate(Input::get('limit', 15));
        return View::make('goods_type.list')->with(compact('list'));
    }

    /**
     * 类目管理
     */
    public function postType()
    {
        $validator = Validator::make(Input::all(), [
            'goods_type_id' => [
                'required',
                'exists:goods_type,id,status,' . GoodsType::STATUS_OPEN
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        $temp = EnterpriseGoodsType::whereGoodsTypeId(Input::get('goods_type_id'));
        if ($temp->get()->isEmpty()) {
            $enterprise_goods_type = new EnterpriseGoodsType();
            $enterprise_goods_type->goodsType()->associate(GoodsType::find(Input::get('goods_type_id')));
            $enterprise_goods_type->save();
            return 'save-success';
        } else {
            // 判断这个类目下是否有商品
            $enterprise_goods = EnterpriseGoods::whereGoodsTypeId(Input::get('goods_type_id'))->first();
            if (is_null($enterprise_goods)) {
                $temp->delete();
                return 'delete-success';
            }
            return Response::make('此类目旗下还有商品，请您先删除此类目下商品', 402);
        }
    }
}