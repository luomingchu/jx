<?php

/**
 * 企业管理控制器
 */
class EnterpriseController extends BaseController
{

    /**
     * 获取企业列表
     */
    public function getList()
    {
        $list = Enterprise::latest()->paginate(Input::get('limit', 15));
        return View::make('enterprise.list')->withData($list);
    }

    /**
     * 添加企业
     */
    public function getEdit()
    {
        Input::has('id') != '' ? $enterprise = Enterprise::where('id', Input::get('id'))->first() : $enterprise = [];
        return View::make('enterprise.edit')->withData($enterprise)->withProvinces(Province::all());
    }

    /**
     * 保存企业信息
     */
    public function postSave()
    {
        // 获取输入。
        $inputs = Input::all();

        // 验证输入。
        $validator = Validator::make($inputs, [
            'domain' => [
                'required',
                'unique:enterprise,domain,' . Input::get('enterprise_id', 0)
            ],
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
            ]
        ], [
            'domain.required' => '企业英文标识不能为空',
            'domain.unique' => '企业英文标识已经存在',
            'province_id.required' => '省份不能为空',
            'province_id.exists' => '省份不存在',
            'city_id.required' => '城市不能为空',
            'city_id.exists' => '城市不存在',
            'name.required' => '企业名称不能为空'
        ]);
        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        // 判断是新增还是编辑
        $enterprise = Input::has('enterprise_id') ? Enterprise::find(Input::get('enterprise_id')) : new Enterprise();

        $enterprise->domain = $inputs['domain'];
        $enterprise->name = $inputs['name'];
        $enterprise->legal = $inputs['legal'];
        $enterprise->contacts = $inputs['contacts'];
        $enterprise->phone = $inputs['phone'];
        $enterprise->address = trim($inputs['address']);
        $enterprise->description = trim($inputs['description']);
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