<?php

class EnterpriseController extends BaseController
{

    /**
     * 修改头像
     */
    public function getAvatar()
    {
        return View::make('configs.image');
    }

    /**
     * 上传头像
     */
    public function avatarProcess()
    {}

    /**
     * 显示企业信息
     */
    public function showInfo()
    {
        // 成交总额统计
        $amount = round(Order::where('status', Order::STATUS_FINISH)->sum('amount'), 2);
        // 成交订单总数统计
        $order_count = Order::where('status', Order::STATUS_FINISH)->count();
        // 企业活动开启数
        $activity_count = Activity::where('status', Activity::STATUS_OPEN)->where('end_datetime', '>=', date('Y-m-d H:i:s'))->count();
        // 开启的任务总数
        $task_count = Task::where('status', Task::STATUS_OPEN)->count();
        // 待处理指店数
        $vstore_count = Vstore::where('status', Vstore::STATUS_ENTERPRISE_AUDITING)->count();
        // 获取企业配置信息
        $config = EnterpriseConfig::whereEnterpriseId($this->enterprise_id)->first();

        return View::make('enterprise.info')->withData(Enterprise::find($this->enterprise_id))->with(compact('amount', 'order_count', 'activity_count', 'task_count', 'vstore_count', 'config'));
    }

    /**
     * 编辑企业信息
     */
    public function editInfo()
    {
        return View::make('enterprise.edit')->withData(Enterprise::find($this->enterprise_id))->withProvinces(Province::all());
    }

    /**
     * 保存企业信息
     */
    public function SaveInfo()
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
            'legal' => [
                'required'
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
            ]
        ], [
            'province_id.required' => '省份不能为空',
            'province_id.exists' => '省份不存在',
            'city_id.required' => '城市不能为空',
            'city_id.exists' => '城市不存在',
            'name.required' => '企业名称不能为空',
            'legal.required' => '法人代表不能为空',
            'contacts.required' => '联系人姓名不能为空',
            'phone.required' => '联系电话不能为空',
            'address.required' => '详细地址不能为空',
            'description.required' => '企业简介不能为空'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('message_error', $validator->messages()
                ->first())
                ->withInput();
        }

        $enterprise = Enterprise::find($this->enterprise_id);

        $enterprise->name = $inputs['name'];
        $enterprise->legal = $inputs['legal'];
        $enterprise->contacts = $inputs['contacts'];
        $enterprise->phone = $inputs['phone'];
        $enterprise->address = $inputs['address'];
        $enterprise->description = $inputs['description'];
        $enterprise->logo_id = $inputs['logo_id'];
        $enterprise->province_id = $inputs['province_id'];
        $enterprise->city_id = $inputs['city_id'];
        $enterprise->district_id = $inputs['district_id'];
        $enterprise->longitude = $inputs['longitude'];
        $enterprise->latitude = $inputs['latitude'];

        $enterprise->save();

        return $enterprise;
    }
}
