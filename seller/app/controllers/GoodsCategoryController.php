<?php
/**
 * 门店商品分类控制器
 */
class GoodsCategoryController extends BaseController
{

    /**
     * 获取商品分类列表
     */
    public function getList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'parent_id' => [
                    'integer',
                    'exists:'.Config::get('database.connections.own.database').'.goods_category,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        if (Input::has('parent_id')) {
            $category = GoodsCategory::find(Input::get('parent_id'));
            return $category->ChildNodes()->get();
        } else {
            return GoodsCategory::where('parent_path', '')->get();
        }
    }
}