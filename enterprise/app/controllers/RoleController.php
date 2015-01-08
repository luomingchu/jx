<?php
//use Illuminate\Database\Capsule\Manager;
/**
 * 角色控制器
 */
class RoleController extends BaseController
{

    /**
     * 获取角色列表
     */
    public function getList()
    {
        $list = Role::with('managers')->get();
        return View::make('role.list')->with(compact('list'));
    }


    /**
     * 保存角色信息
     */
    public function postSave()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'name' => [
                    'required',
                    'unique:roles,name,'.Input::get('id')
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $role = Role::findOrNew(Input::get('id', 0));
        $role->name = Input::get('name');
        $role->remark = Input::get('remark', '');
        $role->status = Input::get('status', Role::STATUS_VALID);
        $role->save();

        return $role;
    }


    /**
     * 删除角色
     */
    public function postDelete()
    {
        if (!Input::has('role_id')) {
            return Response::make('请先选择要删除的角色', 402);
        }
        $role = Role::find(Input::get('role_id'));
        if (empty($role)) {
            return Response::make('没有相关角色信息', 402);
        }

        $role->delete();

        return 'success';
    }

    /**
     * 切换角色状态
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'role_id' => [
                    'required',
                    'exists:roles,id',
                ],
                'status' => [
                    'required',
                    'in:'.Role::STATUS_VALID.','.Role::STATUS_INVALID
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $role = Role::find(Input::get('role_id'));
        $role->status = Input::get('status') == Role::STATUS_INVALID ? Role::STATUS_VALID : Role::STATUS_INVALID;
        $role->save();

        return $role;
    }


    /**
     * 查看角色成员
     */
    public function getManagers()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'role_id' => [
                    'required',
                    'exists:roles,id',
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $role = Role::find(Input::get('role_id'));
        // 获取角色已分配的成员
        $members = $role->managers;
        $members->isEmpty() ? $members = [] : $members = $members->modelKeys();
        // 获取后台增加的管理员列表
        $managers = Manager::where('is_super',Manager::SUPER_INVALID)->get();
        return View::make('role.manager')->with(compact('members', 'managers', 'role'));
    }


    /**
     * 分别角色成员
     */
    public function postAssignManager()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'role_id' => [
                    'required',
                    'exists:roles,id',
                ],
                'manager' => [
                    'exists:managers,id',
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $role = Role::find(Input::get('role_id'));

        $role->managers()->sync((array)Input::get('manager', []));
        return 'success';
    }

    /**
     * 查看角色权限
     */
    public function getAssignPurview($role_id)
    {
        $info = Role::find($role_id);

        // 获取角色以分配的权限
        $purview_list = $info->purviews;
        $purview_list->isEmpty() ? $purview_list = [] : $purview_list = $purview_list->modelKeys();

        // 获取系统所有权限
        $list = Purview::where('status', Purview::STATUS_VALID)->get()->toArray();
        // 递归生成层级形式的权限列表
        $tree_node = $this->returnTreeNode($list);
        // 生成层级形式页面
        $html = $this->returnTreeView($tree_node, $purview_list);

        return View::make('role.purview')->with(compact('html', 'info'));
    }


    /**
     * 递归生成层级形式的权限列表
     */
    protected function returnTreeNode($list, $index  = 0)
    {
        $tree_nodes = [];
        foreach ($list as $node) {
            if ($node['parent_id'] == $index) {
                $node['sub_node'] = $this->returnTreeNode($list, $node['id']);
                $tree_nodes[$node['id']] = $node;
            }
        }
        return array_sort($tree_nodes, function($value)
        {
            return $value['sort_order'];
        });
    }

    /**
     * 生成层级形式页面
     */
    protected function returnTreeView($list, $purview_list) {
        $html = "";
        $sub = array_filter(array_fetch($list, 'sub_node'));
        if (empty($sub)) {
            $html .= '<div class="sub_rule_module" style="margin-left: 30px;margin-top: 10px;">';
            foreach ($list as $item) {
                $checked = '';
                if (in_array($item['id'], $purview_list) || $item['id'] == 136) {
                    $checked = "checked='checked'";
                }
                $html .= <<<HTML
<span class='node purview_node' style='color: #000;width: 200px; margin-right: 10px;display: inline-block;cursor: pointer;' data-toggle="tooltip" data-placement="top" title="{$item['remark']}"><i style="display: inline-block;width: 15px;height: 15px;position: relative;left: 17px;top: 4px;z-index: 1000;"></i><input type="checkbox"  name="purview_id[]" value="{$item['id']}" {$checked}/> {$item['name']}</span>
HTML;
            }
            $html .= '</div>';
        } else {
            foreach ($list as $item) {
                $level = count(array_filter(explode(':', $item['path']))) - 1;
                $style = "";
                $span_style = "width: 200px;";
                $div_style = "";
                $checked = '';
                if (in_array($item['id'], $purview_list) || $item['id'] == 136) {
                    $checked = "checked='checked'";
                }
                if (empty($level)) {
                    $style = "border:1px solid #EBEBEB;margin-bottom:20px;padding-bottom:10px;";
                    $span_style = "background:#ECECEC;font-weight:bolder;padding:5px 15px;";
                    $div_style = "background: #ECECEC;";
                } else {
                    $style = 'margin-left: 30px;';
                }
                $sub_html = '';
                if (! empty($item['sub_node'])) {
                    $sub_html = $this->returnTreeView($item['sub_node'], $purview_list);
                }
                $html .= <<<HTML
<div class="rule_module" style="margin-top: 10px;color: #000;{$style}"><div style="{$div_style}"><span data-id='{$item['id']}' class='parent_node purview_node' style='{$span_style}color: #000; margin-right: 10px;display: inline-block;cursor: pointer;' data-toggle="tooltip" data-placement="top" title="{$item['remark']}"><i style="display: inline-block;width: 15px;height: 15px;position: relative;left: 17px;top: 4px;z-index: 1000;"></i><input type="checkbox" name="purview_id[]" value="{$item['id']}"  {$checked}/> {$item['name']}</span></div>{$sub_html}</div>
HTML;

            }
        }
        return $html;
    }


    /**
     * 保存角色权限
     */
    public function postAssignPurview()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'role_id' => [
                    'required',
                    'exists:roles,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $role = Role::find(Input::get('role_id'));

        $purview_ids = Input::get('purview_id', []);

        // 同步角色和权限的关联
        $role->purviews()->sync($purview_ids);
        return 'success';
    }
}