<?php
/**
 * 门店管理员&区域负责人管理
 * @author jois
 */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class StoreManagerController extends BaseController
{

    /**
     * 区域负责人列表
     */
    public function getAreaManagerList()
    {
        // 获得第一级组织
        $group = Group::whereParentPath('')->get();

        $storeManagers = StoreManager::with('storeManageArea.item')->whereStoreRoleId(1);
        // 用户名筛选
        if (Input::has('username')) {
            $storeManagers->where('username', 'like', "%" . Input::get('username') . "%");
        }
        // 门店名称筛选
        if (Input::has('store_name')) {

            $store_ids = Store::where('name', 'like', "%" . Input::get('store_name') . "%")->lists('id');
            $storeManagers->whereIn('store_id', $store_ids);
        }
        if (Input::has('group_id')) {
            $group_ids = array_filter(Input::get('group_id'));
            $word = end($group_ids);
            if ($word) {
                // 取得这个组织及旗下所有子级组织
                $child_nodes = Group::find($word)->childNodes(true)->lists('id');
                $store_manager_ids = StoreManageArea::whereIn('item_id', $child_nodes)->lists('store_manager_id');
                // 取得这些组织下的所有负责人
                $storeManagers->whereIn('id', $store_manager_ids);
            }
        }

        $storeManagers = $storeManagers->oldest('created_at')->paginate(15);
        return View::make('store-manager.am-list')->withData($storeManagers)->withGroup($group);
    }

    /**
     * 编辑区域负责人
     */
    public function getAreaManagerEdit($id = 0)
    {
        // 获得第一级商品分类
        $group = Group::whereParentPath('')->get();
        // 获得修改数据
        $data = StoreManager::find($id);
        // 如果是编辑，则找出对应的组织，并且进行每行循环，每行中包括第一级的到此最后节点的遍历
        $group_data = array();
        $group_id = array();
        if (! is_null($data)) {
            $group_ids = StoreManageArea::whereStoreManagerId($id)->lists('item_id');
            foreach ($group_ids as $key => $item) {
                $pid = Group::find($item);
                $path = $pid->path;
                $path_ids = array_filter(explode(':', $path));
                foreach ($path_ids as $key2 => $dd) {
                    // 找出这个当前级的所有组织
                    $parent_path = Group::find($dd)->parent_path;
                    $group_data[$key][$key2] = Group::whereParentPath($parent_path)->get()->toArray();
                    $group_id[$key][$key2] = $dd;
                }
            }
        }

        return View::make('store-manager.am-edit')->withData($data)
            ->withGroup($group)
            ->withGroupData($group_data)
            ->withGroupId($group_id);
    }

    /**
     * 保存门店管理员信息
     */
    public function postAreaManagerSave()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'username' => [
                'required',
                'between:2,16',
                'unique:store_manager,username,' . Input::get('id')
            ],
            'group' => 'required',
            'password' => [
                'between:6,16'
            ]
        ], [
            'username.required' => '用户名不能为空',
            'username.between' => '用户名格式错误，必须是2到16位字符',
            'username.unique' => '用户名已经被注册',
            'password.between' => '密码格式错误，密码为6到16位字符'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('message_error', $validator->messages()
                ->first())
                ->withInput();
        }

        if (Input::get('id', 0) == 0 && ! Input::has('password')) {
            return Redirect::back()->with('message_error', '新增区域负责人，密码不能为空')->withInput();
        }

        // 获取组织最终值
        $group = array_flatten(array_unique(array_filter(Input::get('group'))));
        // 去除组织中有子类的父类
        $new_gids = $group;
        foreach ($group as $key1 => $gid1) {
            $gids = Group::find($gid1)->childNode()->lists('id');
            foreach ($group as $key2 => $gid2) {
                if (in_array($gid2, $gids)) {
                    unset($new_gids[$key1]);
                }
            }
        }

        $store_manager = Input::get("id", 0) > 0 ? StoreManager::find(Input::get("id")) : new StoreManager();
        $store_manager->username = trim(Input::get('username'));
        $store_manager->store_id = 0;
        $store_manager->store_role_id = 1;
        if (Input::has('password')) {
            $store_manager->password = trim(Input::get('password'));
        }
        $store_manager->save();

        // 删除旧所管区域
        if (Input::get('id', 0) > 0) {
            StoreManageArea::whereStoreManagerId($store_manager->id)->delete();
        }
        // 保存所管区域
        foreach ($new_gids as $gid) {
            $store_manager_area = new StoreManageArea();
            $store_manager_area->storeManager()->associate($store_manager);
            $store_manager_area->item()->associate(Group::find($gid));
            $store_manager_area->save();
        }

        return Redirect::route("AreaStoreManagerList")->withMessageSuccess('保存成功');
    }

    /**
     * 删除区域负责人
     */
    public function deleteAreaManager()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:store_manager,id'
            ]
        ], [
            'id.required' => '要删除的区域负责人不能为空',
            'id.exists' => '要删除的区域负责人不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('AreaStoreManagerList')->withMessageError($validator->messages()
                ->first());
        }

        $store_manager = StoreManager::find(Input::get('id'));

        // 执行删除
        StoreManageArea::whereStoreManagerId($store_manager->id)->delete();
        $store_manager->delete();

        // 跳转回列表页。
        return Redirect::route('AreaStoreManagerList')->withMessageSuccess('删除成功');
    }

    /**
     * 门店管理员列表
     */
    public function getList()
    {
        $storeManagers = StoreManager::with('store')->whereStoreRoleId(2);

        // 用户名筛选
        if (Input::has('username')) {
            $storeManagers->where('username', 'like', "%" . Input::get('username') . "%");
        }

        // 门店名称筛选
        if (Input::has('store_name')) {

            $store_ids = Store::where('name', 'like', "%" . Input::get('store_name') . "%")->lists('id');
            $storeManagers->whereIn('store_id', $store_ids);
        }

        $storeManagers = $storeManagers->oldest('created_at')->paginate('15');
        return View::make('store-manager.list')->withData($storeManagers);
    }

    /**
     * 编辑门店管理员信息
     */
    public function getEdit($id = 0)
    {
        $stores = Store::all();
        $id > 0 ? $storeManager = StoreManager::find($id) : $storeManager = new StoreManager();
        return View::make('store-manager.edit')->withData($storeManager)->withStores($stores);
    }

    /**
     * 保存门店管理员信息
     */
    public function postSave()
    {
        // 获取输入。
        $inputs = Input::all();

        // 验证输入。
        $validator = Validator::make($inputs, [
            'username' => [
                'required',
                'between:2,16',
                'unique:store_manager,username,' . $inputs['id']
            ],
            'store_id' => [
                'required',
                'unique:store_manager,store_id,' . $inputs['id']
            ],
            'password' => [
                'between:6,16'
            ]
        ], [
            'username.required' => '用户名不能为空',
            'username.unique' => '用户名已经被注册',
            'store_id.required' => '请选择门店',
            'store_id.unique' => '该门店只允许有一个门店管理员',
            'password.between' => '密码格式错误，密码为6到16位字符'
        ]);
        if ($validator->fails()) {
            return $validator->messages()->first();
        }
        Input::get("id", 0) > 0 ? $storeManager = StoreManager::find(Input::get("id")) : $storeManager = new StoreManager();

        $storeManager->username = $inputs['username'];
        $storeManager->store_id = $inputs['store_id'];
        $storeManager->store_role_id = 2;

        if (Input::has('password')) {
            $storeManager->password = $inputs['password'];
        }

        $storeManager->save();

        // 保存到所管区域
        $store_manage_area = StoreManageArea::whereStoreManagerId($storeManager->id)->first();
        if (is_null($store_manage_area)) {
            $store_manage_area = new StoreManageArea();
        }
        $store_manage_area->storeManager()->associate($storeManager);
        $store_manage_area->item()->associate(Store::find($inputs['store_id']));
        $store_manage_area->save();

        return $storeManager;
    }

    /**
     * 删除门店管理员信息
     */
    public function delete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:store_manager,id'
            ]
        ], [
            'id.required' => '要删除的门店管理员不能为空',
            'id.exists' => '要删除的门店管理员不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('storeManagerList')->withMessageError($validator->messages()
                ->first());
        }

        $storeManager = StoreManager::find(Input::get('id'));

        // 执行删除
        StoreManageArea::whereStoreManagerId($storeManager->id)->delete();
        $storeManager->delete();

        // 跳转回列表页。
        return Redirect::route('storeManagerList')->withMessageSuccess('删除成功');
    }
}
