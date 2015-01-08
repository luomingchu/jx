<?php

/**
 * 广告管理
 *
 */
class AdvertiseController extends BaseController
{

    /**
     * 广告位列表
     */
    public function getList()
    {
        // 根据类型查询
        $ad = Advertise::with('space');
        if (Input::has('space_id')) {
            $ad->whereSpaceId(Input::get('space_id'));
        }
        if (Input::has('keyword')) {
            $word = Input::get('keyword');
            $ad->where('title', 'like', "%{$word}%")
                ->latest()
                ->paginate(15);
        }

        $list = $ad->orderBy('sort','asc')->paginate(Input::get('limit', 15));
        return View::make('advertise.list')->withList($list)->withSpace(AdvertiseSpace::all());
    }

    /**
     * 编辑广告位
     */
    public function getEdit()
    {
        // 获取广告位列表
        $spaceList = AdvertiseSpace::all();

        $goods_list = [];
        if (Input::has('id')) {
            $info = Advertise::find(Input::get('id'));
            if ($info && $info->kind == Advertise::KIND_GOODS && ! empty($info->popularize_goods)) {
                $goods_list = EnterpriseGoods::with('pictures')->whereIn('id', explode(',', $info->popularize_goods))->get();
            }
        }

        // 获得第一级商品分类
        $category = GoodsCategory::whereParentPath('')->get();

        return View::make('advertise.edit')->with(compact('info', 'spaceList', 'category', 'goods_list'));
    }

    /**
     * 保存编辑
     */
    public function postSave()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), array(
            'space_id' => array(
                'required',
                'exists:advertise_spaces,id'
            ),
            'title' => array(
                'required',
                'max:255'
            ),
            'picture_id' => array(
                'required',
            ),
            'kind' => [
                'required',
                'in:'.Advertise::KIND_GOODS.','.Advertise::KIND_CUSTOM
            ],
            'popularize_goods' => [
                'required_if:kind,'.Advertise::KIND_GOODS
            ],
            'template_picture_id' => [
                'required_if:kind,'.Advertise::KIND_GOODS
            ],
            'template_name' => [
                'required_if:kind,'.Advertise::KIND_GOODS
            ],
            'sort' => array(
                'integer',
                'min:0'
            )
        ));
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要保存的对象。
        $advertise = Advertise::findOrNew(Input::get('id', 0));

        // 填充提交的数据。
        $advertise->space_id = Input::get('space_id');
        $advertise->title = Input::get('title');
        $advertise->url = Input::get('url', '');
        $advertise->picture_id = Input::get('picture_id');
        $advertise->kind = Input::get('kind');
        $advertise->template_picture_id = Input::get('template_picture_id', 0);
        $advertise->popularize_goods = Input::get('popularize_goods', '');
        $advertise->template_name = Input::get('template_name', '');
        $advertise->content = Input::get('content', '');
        $advertise->additional_content = Input::get('additional_content', '');
        $advertise->remark = Input::get('remark', '');
        $advertise->sort = Input::get('sort_order', 100);
        $advertise->push_msg = Input::get('push_msg', '');
        $advertise->status = Input::get('status', Advertise::STATUS_OPEN);
        // 保存数据。
        $advertise->save();

        return $advertise;
    }

    /**
     * 删除广告
     */
    public function postDelete()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'advertise_id' => [
                    'required',
                    'exists:advertises,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        Advertise::whereIn('id', (array)Input::get('advertise_id'))->delete();
        return 'success';
    }


    /**
     * 切换状态
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'advertise_id' => [
                    'required',
                    'exists:advertises,id'
                ],
                'status' => [
                    'required',
                    'in:'.Notice::STATUS_OPEN.','.Notice::STATUS_CLOSE
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $info = Advertise::find(Input::get('advertise_id'));
        if (Input::get('status') == Advertise::STATUS_OPEN) {
            $info->status = Advertise::STATUS_CLOSE;
        } else {
            $info->status = Advertise::STATUS_OPEN;
        }
        $info->save();

        return 'success';
    }

}
