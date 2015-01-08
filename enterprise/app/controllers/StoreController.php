<?php
use Illuminate\Support\Facades\Auth;

class StoreController extends BaseController
{

    /**
     * 门店列表
     */
    public function getList()
    {
        $provinces = Province::all();

        $stores = Store::with('group');

        // 企业名称筛选
        if (Input::has('name')) {
            $stores->where('name', 'like', "%" . Input::get('name') . "%");
        }

        // 省份筛选
        if (Input::has('province_id')) {
            $stores->where('province_id', Input::get('province_id'));
        }

        // 城市筛选
        if (Input::has('city_id')) {
            $stores->where('city_id', Input::get('city_id'));
        }

        // 地区筛选
        if (Input::has('district_id')) {
            $stores->where('district_id', Input::get('district_id'));
        }

        $stores = $stores->orderBy('type')->paginate('15');
        return View::make('store.list')->withData($stores)->withProvinces($provinces);
    }

    /**
     * 编辑门店信息
     */
    public function getEdit($id = 0)
    {
        $store = $id > 0 ? Store::with('group')->find($id) : new Store();

        // 企业门店组织列表
        $groups = Group::where('parent_path', '')->get();

        return View::make('store.edit')->withData($store)
            ->withProvinces(Province::all())
            ->withGroups($groups);
    }

    /**
     * 保存门店信息
     */
    public function postSave()
    {
        // 获取输入。
        $inputs = Input::all();

        // 验证输入。
        $validator = Validator::make($inputs, [
            'province_id' => [
                'required',
                'exists:province,id'
            ],
            'city_id' => [
                'required',
                'exists:city,id'
            ],
            'name' => [
                'required'
            ],
            'type' => [
                'in:' . Store::MAIN . ',' . Store::BRANCH . ',' . Store::DIRECT
            ],
            'contacts' => [
                'required'
            ],
            'phone' => [
                'required'
            ],
            'address' => [
                'required'
            ],
            'description' => [
                'required'
            ],
            'longitude' => [
                'required'
            ],
            'latitude' => [
                'required'
            ],
            'group_id' => [
                'required_without:ori_group_id'
            ],
            'ori_group_id' => [
                'required_without:group_id'
            ]
        ], [
            'province_id.required' => '省份不能为空',
            'province_id.exists' => '省份不存在',
            'city_id.required' => '城市不能为空',
            'city_id.exists' => '城市不存在',
            'name.required' => '门店名称不能为空',
            'type.in' => '门店类型只能分销商、总店或者直营店',
            'contacts.required' => '联系人姓名不能为空',
            'phone.required' => '联系电话不能为空',
            'address.required' => '详细地址不能为空',
            'description.required' => '门店简介不能为空',
            'longitude.required' => '门店经度不能为空',
            'latitude.required' => '门店纬度不能为空'
        ]);
        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        //TODO 1.0内购测试版使用正式版需要删除
        /* if(!Input::has('id') && Store::count() > 0){
            return Response::make('指帮连锁电商版v1.0.1，只支持一个门店，如需要设置多门店，请您联系“厦门速卖通网络科技有限公司”进行升级版本。', 402);
        } */

        Input::get("id", 0) > 0 ? $store = Store::find(Input::get("id")) : $store = new Store();

        $store->name = trim($inputs['name']);
        $store->type = $inputs['type'];
        $store->contacts = trim($inputs['contacts']);
        $store->phone = trim($inputs['phone']);
        $store->address = trim($inputs['address']);
        $store->description = trim($inputs['description']);
        $store->logo_id = $inputs['logo_id'];
        $store->province_id = $inputs['province_id'];
        $store->city_id = $inputs['city_id'];
        $store->district_id = $inputs['district_id'];
        $store->longitude = $inputs['longitude'];
        $store->latitude = $inputs['latitude'];

        // 如果是修改门店信息并且没有修改所属组织
        $group_id = array_filter(Input::get('group_id'));
        if (empty($group_id) && Input::has('id')) {
            $store->group_id = Input::get('ori_group_id');
        } else {
            $store->group_id = end($group_id);
        }
        $store->save();

        return $store;
    }

    /**
     * 删除门店
     */
    public function delete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:store,id'
            ]
        ], [
            'id.required' => '要删除的门店不能为空',
            'id.exists' => '要删除的门店不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('StoreList')->withMessageError($validator->messages()
                ->first());
        }

        // 查找store
        $store = Store::find(Input::get('id'));

        // 门店下是否有状态为OPEN的指店
        $vstore = $store->vstores()->where('status', Vstore::STATUS_OPEN)->get();

        if (! ($vstore->isEmpty() )) {
            return Redirect::route('StoreList')->withMessageError("该门店下有开启的指店，不能删除");
        }

        // 删除
        $store->delete();

        // 返回结果
        return Redirect::route('StoreList')->withMessageSuccess('门店删除成功');
    }

    /**
     * 获取门店下的指定列表（ajax)
     */
    public function ajaxVstoreList()
    {
        $validator = Validator::make(Input::all(), [
            'store_id' => [
                'required',
                'exists:store,id'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Vstore::where('store_id', Input::get('store_id'))->get();
    }

    /**
     * 门店批量导入
     */
    public function multiImportStore()
    {
        if (! Input::hasFile('file')) {
            return Redirect::route('StoreList')->with('message_error', '请先选择文件后在进行提交！');
        }
        $num = 0;
        $type = [
            '总店' => Store::MAIN,
            '直营店' => Store::DIRECT,
            '加盟店' => Store::BRANCH
        ];
        $groups = Group::all();
        $groups->isEmpty() || $groups = array_column($groups->toArray(), 'id', 'name');

        Excel::selectSheetsByIndex(0)->filter('chunk')->load(Input::file('file'))->chunk(100, function($results) use (&$num, $type, $groups)
        {
            // 批量写入数据库
            foreach($results->toArray() as $row)
            {
                if (empty($row[1]) || $row[1] == '门店名称') {
                    continue;
                }
                $store = Store::where('name', $row[1])->first();
                empty($store) && $store = new Store();
                $store->name = $row[1];
                $store->type = $type[$row[2]];
                $store->group_id = empty($groups[$row[3]]) ? 0 : $groups[$row[3]];
                $store->contacts = $row[4];
                $store->phone = $row[5];
                $store->address = $row[7];
                $store->description = $row[8];
                $store->province_id = 0;
                $store->city_id = 0;
                $store->district_id = 0;
                if (! empty($row[6])) {
                    $area = array_filter(explode('#', $row[6]));
                    if (!empty($area[0])) {
                        $store->province_id = Province::where('name', $area[0])->pluck('id');
                    }
                    if (!empty($area[1])) {
                        $store->city_id = City::where('name', $area[1])->pluck('id');
                    }
                    if (!empty($area[2])) {
                        $store->district_id = District::where('name', $area[2])->pluck('id');
                    }
                }
                $store->save();
                ++$num;
            }
//            foreach($results->toArray() as $row)
//            {
//                if (empty($row[1]) || $row[1] == '门店名称') {
//                    continue;
//                }
//                $store = Store::where('name', $row[1])->first();
//                empty($store) && $store = new Store();
//                $store->name = $row[1];
//                $store->type = $type[$row[2]];
//                $store->group_id = empty($groups[$row[3]]) ? 0 : $groups[$row[3]];
//                $store->contacts = $row[4];
//                $store->phone = $row[5];
//                $store->address = $row[7];
//                $store->description = $row[8];
//                $store->province_id = 0;
//                $store->city_id = 0;
//                $store->district_id = 0;
//                if (! empty($row[6])) {
//                    $area = array_filter(explode('#', $row[6]));
//                    if (!empty($area[0])) {
//                        $store->province_id = Province::where('name', $area[0])->pluck('id');
//                    }
//                    if (!empty($area[1])) {
//                        $store->city_id = City::where('name', $area[1])->pluck('id');
//                    }
//                    if (!empty($area[2])) {
//                        $store->district_id = District::where('name', $area[2])->pluck('id');
//                    }
//                }
//                $store->save();
//                ++$num;
//            }
        });

        return Redirect::route('StoreList')->with('message_success', "上传成功，共批量导入{$num}个门店！");
    }
}
