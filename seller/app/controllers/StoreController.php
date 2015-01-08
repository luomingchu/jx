<?php
/**
 * 门店控制器
 */
class StoreController extends BaseController
{

    /**
     * 获取指定门店的详细信息
     */
    public function getInfo()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'store_id' => 'required',
                'exists:' . Config::get('database.connections.own.database') . '.store,id'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Store::with('province', 'city', 'district')->find(Input::get('store_id'));
    }


    /**
     * 获取门店列表
     */
    public function getList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'limit' => [
                    'integer',
                    'between:1,200'
                ],
                'page' => [
                    'integer',
                    'min:1'
                ],
                'province_id' => [
                    'exists:province,id'
                ],
                'city_id' => [
                    'exists:city,id'
                ],
                'district_id' => [
                    'exists:district,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $store = Store::latest();

        if (Input::has('district_id')) {
            $store->where('district_id', Input::get('district_id'));
        } else if (Input::has('city_id')) {
            $store->where('city_id', Input::get('city_id'));
        } else if (Input::has('province_id')) {
            $store->where('province_id', Input::get('province_id'));
        }

        return $store->paginate(Input::get('limit', 15))->getCollection();
    }

}