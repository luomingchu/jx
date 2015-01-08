<?php

/**
 * 企业后台-商品分类管理控制器
 *
 * @author jois
 */
class GoodsCategoryController extends BaseController
{

    /**
     * 商品分类列表
     */
    public function getList()
    {
        // 获得第一级商品分类
        $category = GoodsCategory::e()->whereParentPath('')->get();

        // 根据参数获取商品分类信息
        $data = GoodsCategory::e()->orderBy('sort', 'desc')->paginate(15);
        if (Input::has('category_id')) {
            $category_ids = array_filter(Input::get('category_id'));
            $word = end($category_ids);
            if ($word) {
                $data = GoodsCategory::e()->where('parent_path', 'like', "%:{$word}:%")->orWhere('id', $word)->orderBy('sort', 'desc')->paginate(15);
            }
        }

        // 返回视图
        return View::make('goods-category.list')->withData($data)->withCategory($category);
    }

    /**
     * 新增&编辑商品分类
     */
    public function edit($id = 0)
    {
        // 获得第一级商品分类
        $category = GoodsCategory::e()->whereParentPath('')->get();

        // 获取修改的商品分类信息
        $data = GoodsCategory::find($id);
        if ($id > 0) {
            $parent_node = $data->parentNode()->first();
            // 返回视图
            return View::make('goods-category.edit')->withData($data)
                ->withParentNode($parent_node)
                ->withCategory($category);
        }

        // 返回视图
        return View::make('goods-category.edit')->withData($data)->withCategory($category);
    }

    /**
     * 商品分类保存
     */
    public function save()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), array(
            'id' => 'exists:goods_category,id',
            'name' => 'required|max:128',
            'path' => 'required'
        ), array(
            'id.exists' => '商品分类不存在！',
            'name.required' => '商品分类名称不能为空！',
            'name.max' => '商品分类名称不能超过128个字符',
            'path.required' => '父级分类不能为空！'
        ));

        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            Input::flash();
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        // 取得要保存的对象。
        $id = Input::has('id') ? Input::get('id') : 0;
        $parent_id = array_filter(Input::get('path'));
        $goods_category = $id > 0 ? GoodsCategory::find($id) : new GoodsCategory();

        // 修改时判断
        if ($id > 0 && ! empty($parent_id)) {
            // 上级分类不能为自己，及其子孙分类所在分类
            $parent_info = GoodsCategory::find(end($parent_id));

            $path_node = array_filter(explode(':', $parent_info->path));
            if (in_array($id, $path_node)) {
                return Redirect::route("GoodsCategoryEdit", $id)->withInput()->withMessageError('修改失败，新的父级分类不能是其本类或其子孙分类');
            }
        }

        // 上级为全部分类，即新增的为第一级分类
        $parent_id = empty($parent_id) ? 0 : end($parent_id);

        // 保存数据。
        $goods_category->enterprise()->associate($this->enterprise_info);
        $goods_category->name = trim(Input::get('name'));
        $goods_category->parent_id = $parent_id;
        $goods_category->save();

        return Redirect::route("GoodsCategoryList")->withMessageSuccess('保存成功');
    }

    /**
     * 删除商品分类
     */
    public function delete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:goods_category,id'
            ]
        ], [
            'id.required' => '要删除的商品分类不能为空',
            'id.exists' => '要删除的商品分类不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('GoodsCategoryList')->withMessageError($validator->messages()
                ->first());
        }

        // 判断此商品分类是否有商品，有则不能删除
        $child_ids = GoodsCategory::find(Input::get('id'))->childNodes()->lists('id');

        // 判断分类下是否有子级，有不能直接删除
        if (! empty($child_ids)) {
            return Redirect::to(URL::previous())->withMessageError('此商品分类有下级分类，暂时不能删除！');
        }

        array_push($child_ids, Input::get('id'));
        $temp = CategoryGoods::whereIn('goods_category_id', $child_ids)->first();
        if (is_null($temp)) {
            $goods_category = GoodsCategory::find(Input::get('id'));
            $goods_category->delete();
            return Redirect::to(URL::previous())->withMessageSuccess('删除成功');
        }

        return Redirect::to(URL::previous())->withMessageError('此分类底下有商品，需先删除分类下商品');
    }

    /**
     * 获取下级商品分类
     */
    public function subCategorys()
    {
        $goods_category = array();
        $parent_id = Input::get('parent_id');
        if (is_array($parent_id)) {
            $ids = [];
            foreach ($parent_id as $id) {
                $cid = GoodsCategory::find($id)->childNode()->lists('id');
                $ids = array_merge($ids, $cid);
            }
            $goods_category = GoodsCategory::findMany($ids);
        } elseif ($parent_id > 0) {
            $goods_category = GoodsCategory::find(Input::get('parent_id'))->childNode()->get();
        }
        return Response::json($goods_category);
    }
}
