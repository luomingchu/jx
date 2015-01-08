<?php

/**
 * 企业门店组织控制器
 */
class GroupController extends BaseController
{

    /**
     * 组织列表
     */
    public function getList()
    {
        // 获得第一层组织
        $groups = Group::where('parent_path', '')->get();

        $list = Group::orderBy('parent_path', 'asc')->orderBy('sort', 'desc')->paginate(15);
        $group_id = array_filter(Input::get('group_id', []));
        if (! empty($group_id)) {
            $list = Group::where('parent_path', 'like', "%:" . array_pop($group_id) . ":%")->orderBy('parent_path', 'asc')
                ->orderBy('sort', 'desc')
                ->paginate(15);
        }
        // 返回视图
        return View::make('group.list')->with(compact('groups', 'list'));
    }

    /**
     * 新增&编辑组织信息
     */
    public function getEdit($group_id = 0)
    {
        // 获得第一层组织
        $groups = Group::where('parent_path', '')->get();

        // 获取组织信息
        if (! empty($group_id)) {
            $info = Group::find($group_id);
            ! empty($info) && $parent_info = $info->parentNode()->first();
        }

        // 返回视图
        return View::make('group.edit')->with(compact('info', 'groups', 'parent_info'));
    }

    /**
     * 保存组织信息
     */
    public function postSave()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'name' => 'required|max:128|unique:groups,name,' . Input::get('group_id') . ',id',
            'group_id' => 'exists:groups,id',
            'parent_id' => 'required',
            'sort' => 'integer'
        ], array(
            'name.required' => '组织名称不能为空！',
            'name.unique' => '该组织名称已经存在了！',
            'name.max' => '组织分类名称不能超过128个字符！',
            'parent_id.required' => '请指定上级组织！',
            'sort.integer' => '排序值只能为整数！'
        ));

        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()
                ->first())
                ->withInput();
        }

        //TODO 1.0内购测试版使用正式版需要删除
        /* if(!Input::has('group_id') && Group::count() > 0){
            return Redirect::back()->withMessageError('指帮连锁电商版v1.0.1，只支持一个区域，如需要设置多区域，请您联系“厦门速卖通网络科技有限公司”进行升级版本。')
                ->withInput();
        } */

        $group = Input::has('group_id') ? Group::find(Input::get('group_id')) : new Group();
        // 组织父级分类
        $parent_id = array_filter(Input::get('parent_id', []));
        $parent_id = end($parent_id);

        // 检查调整分类的正确性
        if (! empty($parent_id) && Input::has('group_id') && Input::get('modify_group') == 1) {
            // 所属父级分类不能是自己或其子孙分类
            // 获取父级信息
            $parent_info = Group::find($parent_id);
            if ($parent_info->id == $group->id || strpos($parent_info->parent_path, ":{$group->id}:") !== false) {
                return Redirect::back()->withInput()->withMessageError('修改失败，上级分类不能为本身或其原来的子孙分类');
            }
        }

        $group->name = trim(Input::get("name"));
        $group->sort = Input::get('sort');
        $group->parent_id = (! Input::has('group_id') || Input::get('modify_group') == 1) ? $parent_id : Input::get('ori_parent_id');
        $group->save();

        return Redirect::route("GroupList")->withMessageSuccess('保存成功');
    }

    /**
     * 删除组织
     */
    public function postDelete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'group_id' => [
                'required'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取组织信息
        $group = Group::find(Input::get('group_id'));

        // 判断该组织下是否有子孙组织
        if ($group->ChildNode()->count() > 0) {
            return Response::make('此组织下还有子级组织，暂时不能删除！', 402);
        }

        // 判断此组织下是否有门店，有则不能删除
        if ($group->stores()->count() > 0) {
            return Response::make('此组织下还有相关门店，暂时不能删除！', 402);
        }
        // 删除组织
        $group->delete();
        return Redirect::route("GroupList")->withMessageSuccess('删除组织成功');
    }

    /**
     * 获取下级门店列表
     */
    public function getSubGroups()
    {
        $validator = Validator::make(Input::all(), [
            'group_id' => [
                'required',
                'exists:groups,id'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 返回指定组织的下级组织列表
        return Group::find(Input::get('group_id'))->childNode()->get();
    }

    /**
     * 获取下级组织
     */
    public function subGroups()
    {
        $group = array();
        $parent_id = Input::get('parent_id');
        if (is_array($parent_id)) {
            $ids = [];
            foreach ($parent_id as $id) {
                $cid = Group::find($id)->childNode()->lists('id');
                $ids = array_merge($ids, $cid);
            }
            $group = Group::findMany($ids);
        } elseif ($parent_id > 0) {
            $group = Group::find(Input::get('parent_id'))->childNode()->get();
        } else {
            $group = Group::topNodes()->get();
        }
        return Response::json($group);
    }

    /**
     * 获取指定区域下的门店列表
     */
    public function getGroupStores()
    {
        $validator = Validator::make(Input::all(), [
            'group_id' => [
                'exists:groups,id'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        if (Input::has('group_id')) {
            $group_ids = [Input::get('group_id')];
            $groups = Group::find(Input::get('group_id'))->childNode()->get();
            if (! $groups->isEmpty()) {
                foreach ($groups as $g) {
                    $children = $g->ChildNodes()->get();
                    if (!$children->isEmpty()) {
                        $group_ids = array_merge($group_ids, $children->modelKeys());
                    }
                }
            }

            return Store::whereIn('group_id', $group_ids)->get();
        }
        return Store::all();
    }
}