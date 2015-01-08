<?php
/**
 * 收货地址模块
 */
class AddressController extends BaseController
{

    /**
     * 获取指定的地址信息
     */
    public function getInfo()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'address_id' => [
                    'required',
                    'exists:address,id,member_id,'.Auth::user()->id
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Address::find(Input::get('address_id'));
    }


    /**
     * 获取用户默认收货地址
     */
    public function getDefaultReceiptAddress()
    {
        return Address::where('type', Address::TYPE_RECEIPT)->where('member_id', Auth::user()->id)->orderBy('is_default', 'asc')->first();
    }


    /**
     * 获取用户的收货地址列表
     */
    public function getReceiptAddressList()
    {
        return Address::where('type', Address::TYPE_RECEIPT)->where('member_id', Auth::user()->id)->get();
    }


    /**
     * 保存收货地址信息
     */
    public function postSave()
    {
        $validator = Validator::make(Input::all(), [
            'consignee' => [
                'required'
            ],
            'mobile' => [
                'required_without:phone',
                'mobile'
            ],
            'phone' => [
                'required_without:mobile'
            ],
            'zipcode' => [
                'required',
                'regex:/^[0-9]{6}$/'
            ],
            'address' => [
                'required'
            ],
            'province_id' => [
                'required',
                'exists:province,id'
            ],
            'city_id' => [
                'required',
                'exists:city,id'
            ],
            'district_id' => [
                'exists:district,id'
            ],
            'is_default' => [
                'in:' . Address::ISDEFAULT . ',' . Address::UNDEFAULT
            ]
        ], [
            'consignee.required' => '收件人不能为空',
            'mobile.required' => '联系手机号不能为空',
            'mobile.mobile' => '联系手机号格式不正确',
            'zipcode.required' => '邮编不能为空',
            'zipcode.regex' => '邮编格式不正确',
            'address.required' => '收件详细地址不能为空',
            'province_id.required' => '省份不能为空',
            'city_id.required' => '城市不能为空',
            'district_id.required' => '县区不能为空',
            'is_default.in' => '默认地址只能在是与否之间选择'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $province = Input::get('province_id');
        $city = Input::get('city_id');
        $district = Input::get('district_id');

        $address = Address::findOrNew(Input::get('address_id', 0));
        $address->member()->associate(Auth::user());
        $address->consignee = Input::get('consignee');
        $address->mobile = Input::get('mobile', '');
        $address->phone = Input::get('phone', '');
        $address->zipcode = Input::get('zipcode');
        $address->address = Input::get('address');
        $address->province_id = $province;
        $address->city_id = $city;
        $address->district_id = $district;
        $address->region_name = Province::find(Input::get('province_id'))->name.''.City::find(Input::get('city_id'))->name.''.District::find(Input::get('district_id'))->name;
        $address->type = Address::TYPE_RECEIPT;
        $address->is_default = Input::get('is_default', Address::UNDEFAULT);
        $address->save();

        return Address::find($address->id);
    }


    /**
     * 收货地址的删除
     */
    public function postDelete()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'address_id' => [
                    'required',
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取收货地址信息
        $address_info = Auth::user()->address()->find(Input::get('address_id'));

        if (empty($address_info)) {
            return Response::make('没有相关地址信息', 402);
        }

        // 删除此收货地址
        $address_info->delete();

        return 'success';
    }


}