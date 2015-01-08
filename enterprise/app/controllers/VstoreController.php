<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class VstoreController extends BaseController
{

    /**
     * 指店列表
     */
    public function getList()
    {
        $vstores = Vstore::with('store', 'member');

        // 名称筛选
        if (Input::has('name')) {
            $vstores = $vstores->where('name', 'like', "%" . Input::get('name') . "%");
        }

        // 状态筛选
        if (Input::has('status')) {
            $vstores = $vstores->where('status', Input::get('status'));
        }

        // 进行门店搜索
        if (Input::has('store')) {
            $vstores = $vstores->where('store_id', Input::get('store'));
        }

        // 第一级组织区域
        $first_group_id = "";

        // 过滤区域组织
        if (Input::has('group_id')) {
            $group_id = array_filter(Input::get('group_id'));
            $parent_group_id = end($group_id);
            $first_group_id = reset($group_id);

            if (! empty($parent_group_id)) {

                $store_id = array();

                // 区域下所有子区域
                $groups = Group::find($parent_group_id)->allSubGroups()->get();

                // 所有区域对应的门店id
                foreach ($groups as $group) {
                    $stores = Group::find($group->id)->stores()->get();
                    // 门店id
                    foreach ($stores as $store) {
                        $store_id[] = $store->id;
                    }
                }

                if (! empty($store_id)) {
                    $vstores = $vstores->whereIn('store_id', $store_id);
                } else {
                    $vstores = $vstores->where('store_id', '');
                }
            }
        }

        // 获取组织区域
        $groups = Group::where('parent_path', '')->get();

        // 获取企业的所有门店列表
        $store_list = Store::all();

        $vstores = $vstores->orderBy('status')
            ->oldest('created_at')
            ->paginate('15')
            ->appends(Input::all());

        return View::make('vstore.list')->with(compact('vstores', 'groups', 'store_list', 'first_group_id'));
    }

    /**
     * 编辑指店信息
     */
    public function getEdit($id = 0)
    {
        $vstore = Vstore::with('member', 'store')->find($id);

        return View::make('vstore.edit')->withData($vstore);
    }

    /**
     * 保存指店信息
     */
    public function postSave()
    {
        // 获取输入。
        $inputs = Input::all();

        // 验证输入。
        $validator = Validator::make($inputs, [
            'id' => [
                'required',
                'exists:vstore,id'
            ],
            'status' => 'required|in:' . Vstore::STATUS_ENTERPRISE_AUDITED . ',' . Vstore::STATUS_ENTERPRISE_AUDITERROR,
            'enterprise_reject_reason' => 'required_if:status,' . Vstore::STATUS_ENTERPRISE_AUDITERROR
        ], [
            'id.required' => '指店不能为空',
            'id.exists' => '指店不存在',
            'status.required' => '审核结果不能为空',
            'status.in' => '审核状态错误',
            'enterprise_reject_reason.required_if' => '请输入拒绝理由！'
        ]);

        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Response::make($validator->messages()->first(), 402);
        }

        $vstore = Vstore::find(Input::get("id"));
        $vstore->status = $inputs['status'];
        if (Input::get('status') == Vstore::STATUS_ENTERPRISE_AUDITERROR) {
            $vstore->enterprise_reject_reason = $inputs['enterprise_reject_reason'];
        }
        $vstore->save();

        // 通知指店申请人
        Event::listen('messages.audit_store', [
            $vstore
        ]);

        return $vstore;
    }
}
