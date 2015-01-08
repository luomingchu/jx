<?php
/**
 * 权限控制器
 */
class PurviewController extends BaseController
{

    /**
     * 保存权限
     */
    public function postSave()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'id' => [
                    'exists:purviews,id'
                ],
                'name' => [
                    'required',
                ],
                'purview_key' => [
                    'required'
                ],
                'controller' => [
                    'required_if:type,'.Purview::TYPE_ACTION
                ],
                'action' => [
                    'required_if:type,'.Purview::TYPE_ACTION
                ],
                'type' => [
                    'required',
                    'in:'.Purview::TYPE_ACTION.','.Purview::TYPE_MENU
                ],
                'status' => [
                    'required',
                    'in:'.Purview::STATUS_VALID.','.Purview::STATUS_INVALID
                ],
                'sort_order' => [
                    'integer'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取已经有相同的路由名的路由规则
        $have_key = Purview::where('purview_key', Input::get('purview_key'));
        Input::has('id') && $have_key->where('id', '!=', Input::get('id'));
        $have_key = $have_key->get();

        // 如果有相同的路由名，则附加条件必须不能相同
        if (! $have_key->isEmpty()) {
            $query = [];
            if (Input::has('condition')) {
                parse_str(Input::get('condition'), $query);
                count(array_filter($query)) < 1 && $query = [Input::get('condition')];
            }
            foreach ($have_key as $key) {
                if (empty($query)) {
                    if (empty($key->condition)) {
                        return Response::make('已经有相同的权限规则了！', 402);
                    }
                } else {
                    $diff = array_diff_assoc($query, $key->condition);
                    if (empty($diff)) {
                        return Response::make('已经有相同的权限规则了！', 402);
                    }
                }
            }
        }

        try {
            $purview = Purview::findOrNew(Input::get('id', 0));
            $purview->name = Input::get('name');
            $purview->purview_key = Input::get('purview_key');
            $purview->parent_id = Input::get('parent_id');
            $purview->controller = Input::get('controller');
            $purview->action = Input::get('action');
            $purview->type = Input::get('type');
            $purview->condition = Input::get('condition', '');
            $purview->status = Input::get('status');
            $purview->remark = Input::get('remark', '');
            $purview->sort_order = Input::get('sort_order', 100);
            $purview->save();
        } catch (Exception $e) {
            return Response::make($e->getMessage(), 402);
        }


        return $purview;
    }

    /**
     * 删除权限
     */
    public function postDelete()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'id' => [
                    'required',
                ]
            ]
        );

        if ($validator->fails()) {
            return Validator::make($validator->messages()->first(), 402);
        }

        Purview::find(Input::get('id'))->delete();
        return 'success';
    }

    /**
     * 获取权限列表
     */
    public function getList()
    {
        $list = Purview::all()->toArray();
        $list = array_sort($list, function($value)
        {
            return $value['path'];
        });
        $tree_node = $this->returnTreeNode($list);
        $html = $this->returnTreeView($tree_node);
        return View::make('purview.list')->with(compact('list', 'html'));
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
    protected function returnTreeView($list) {
        $html = "";
        $sub = array_filter(array_fetch($list, 'sub_node'));
        if (empty($sub)) {
            $html .= '<div style="margin-left: 30px;margin-top: 10px;">';
            foreach ($list as $item) {
                $html .= <<<HTML
<span data-id='{$item['id']}' class='node' style='color: #000;width: 150px; margin-right: 10px;display: inline-block;cursor: pointer;' data-toggle='popover' data-placement='top'>{$item['name']}</span>
HTML;
            }
            $html .= '</div>';
        } else {
            foreach ($list as $item) {
                $level = count(array_filter(explode(':', $item['path']))) - 1;
                $style = "";
                $span_style = "width: 150px;";
                $div_style = "";
                if (empty($level)) {
                    $style = "border:1px solid #EBEBEB;margin-bottom:20px;padding-bottom:10px;";
                    $span_style = "background:#ECECEC;font-weight:bolder;padding:5px 15px;";
                    $div_style = "background: #ECECEC;";
                }
                $sub_html = '';
                if (! empty($item['sub_node'])) {
                    $sub_html = $this->returnTreeView($item['sub_node']);
                }
                $html .= <<<HTML
<div style="margin-left: 30px;margin-top: 10px;color: #000;{$style}"><div style="{$div_style}"><span data-id='{$item['id']}' class='node' style='{$span_style}color: #000; margin-right: 10px;display: inline-block;cursor: pointer;' data-toggle='popover' data-placement='top'>{$item['name']}</span></div>{$sub_html}</div>
HTML;

            }
        }
        return $html;
    }

    /**
     * 获取权限详情
     */
    public function getInfo()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'id' => [
                    'required',
                ]
            ]
        );

        if ($validator->fails()) {
            return Validator::make($validator->messages()->first(), 402);
        }

        $purview_info = Purview::find(Input::get('id'))->toArray();
        if (! empty($purview_info['condition']) && current(array_keys($purview_info['condition'])) == 0) {
            $purview_info['condition'] = current($purview_info['condition']);
        } else {
            $purview_info['condition'] = http_build_query($purview_info['condition']);
        }
        return $purview_info;
    }
}