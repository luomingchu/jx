<?php

/**
 * 企业后台-商品频道管理控制器
 *
 * @author jois
 */
class GoodsChannelController extends BaseController
{

    /**
     * 商品频道列表
     */
    public function getList()
    {
        // 获得数据
        $data = GoodsChannel::paginate(15);

        // 返回视图
        return View::make('goods-channel.list')->withData($data);
    }

    /**
     * 新增&编辑商品频道
     */
    public function edit($id = 0)
    {
        // 获取修改的商品分类信息
        $data = GoodsChannel::find($id);

        // 返回视图
        return View::make('goods-channel.edit')->withData($data);
    }

    /**
     * 商品频道保存
     */
    public function save()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), array(
            'id' => 'exists:goods_channel,id',
            'name' => 'required|max:32'
        ), array(
            'id.exists' => '商品频道不存在！',
            'name.required' => '商品频道名称不能为空！',
            'name.max' => '商品频道名称不能超过32个字符'
        ));
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            Input::flash();
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        // 取得要保存的对象。
        $goods_channel = Input::get('id', 0) > 0 ? GoodsChannel::find(Input::get('id')) : new GoodsChannel();

        // 保存数据。
        $goods_channel->name = trim(Input::get('name'));
        $goods_channel->save();

        return Redirect::route("GoodsChannelList")->withMessageSuccess('保存成功');
    }

    /**
     * 删除商品频道
     */
    public function delete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:goods_channel,id'
            ]
        ], [
            'id.required' => '要删除的商品频道不能为空',
            'id.exists' => '要伤处的商品频道不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('GoodsChannelList')->withMessageError($validator->messages()
                ->first());
        }

        // 判断此商品分类是否有商品，有则不能删除
        $temp = Goods::whereGoodsChannelId(Input::get('id'))->first();
        if (is_null($temp)) {
            $goods_channel = GoodsChannel::find(Input::get('id'));
            $goods_channel->delete();
            return Redirect::route('GoodsChannelList')->withMessageSuccess('删除成功');
        }

        return Redirect::route('GoodsChannelList')->withMessageError('此频道底下有商品，需先删除频道下商品');
    }
}
