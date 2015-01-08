<?php
/**
 * 评论控制器
 */
class CommentController extends BaseController
{

    /**
     * 获取指定商品的评论列表
     */
    public function getGoodsCommentList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'enterprise_goods_id' => [
                    'required'
                ],
                'limit' => [
                    'integer',
                    'between:1,200'
                ],
                'page' => [
                    'integer',
                    'min:1'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Comment::where('enterprise_goods_id', Input::get('enterprise_goods_id'))->latest()->paginate(Input::get('limit', 15))->getCollection();
    }
}