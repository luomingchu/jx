<?php
/**
 * 收货地址控制器
 */
class AddressController extends BaseController
{

    /**
     * 收货地址列表
     */
    public function index()
    {
        $list = Address::where('type', Address::TYPE_RECEIPT)->where('member_id', Auth::user()->id)->get();
        return View::make('address.index')->with(compact('list'));
    }

    /**
     * 编辑收货地址
     */
    public function getEdit()
    {
        $info = null;
        if (Input::has('address_id')) {
            $info = Address::where('member_id', Auth::user()->id)->where('id', Input::get('address_id'))->first();
        }
        // 获取省份列表
        $province_list = Province::all();

        if ($info) {
            $city_list = City::where('province_id', $info->province_id)->get();
            $district_list = District::where('city_id', $info->city_id)->get();
        }

        return View::make('address.edit')->with(compact('info', 'city_list', 'district_list' , 'province_list'));
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
     * 获取城市列表
     */
    public function getCityList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'province_id' => [
                    'required',
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return City::where('province_id', Input::get('province_id'))->get();
    }


    /**
     * 获取区、县列表
     */
    public function getDistrictList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'city_id' => [
                    'required',
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return District::where('city_id', Input::get('city_id'))->get();
    }
}