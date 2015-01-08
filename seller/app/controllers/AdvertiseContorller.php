<?php
use Illuminate\Support\Facades\Redirect;
/**
 * 广告
 */
class AdvertiseController extends BaseController
{

    /**
     * 获取广告位列表
     */
    public function getAdvertiseSpaceList()
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
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return AdvertiseSpace::latest()->paginate(Input::get('limit', 10))->getCollection();
    }

    /**
     * 获取广告
     */
    public function getAdvertiseList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'key_code' => [
                    'required',
                    'exists:'.Config::get('database.connections.own.database').'.advertise_spaces,key_code'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取对应广告位的广告列表
        $advertiseSpace = AdvertiseSpace::where('key_code', Input::get('key_code'))->first();

        // 根据广告位容量显示广告
        $limit = empty($advertiseSpace->limit) ? 100 : $advertiseSpace->limit;
        return Advertise::where('space_id', $advertiseSpace->id)->where('status', Advertise::STATUS_OPEN)->orderBy('sort', 'asc')->take($limit)->get();
    }


    /**
     * 获取广告详情
     */
    public function getAdvertiseInfo($advertise_id = 0, $vstore_id = 0)
    {
        empty($advertise_id) && $advertise_id = Input::get('advertise_id');
        empty($vstore_id) && $vstore_id = Input::get('vstore_id');
        $validator = Validator::make(
            ['advertise_id' => $advertise_id],
            [
                'advertise_id' => [
                    'exists:'.Config::get('database.connections.own.database').'.advertises,id,deleted_at,NULL'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $http_host = explode('.', Request::server('HTTP_HOST'));
        $http_host[1] = 'm';
        $http_host = implode('.', $http_host);
        $goods_url = "http://{$http_host}/goods/info";


        $info = Advertise::find($advertise_id);

        $vstore = Vstore::find($vstore_id);

        $logined = 0;
        if (Auth::check()) {
            $logined = 1;
        }

        if ($info->kind == Advertise::KIND_GOODS) {
            $store = Store::where('id', $vstore->store_id)->first();
            $goods_list = Goods::with('stocks')->where('store_id', $store->id)->whereIn('enterprise_goods_id', explode(',', $info->popularize_goods))->get();
            return View::make("advertise.{$info->template_name}")->with(compact('info', 'goods_list', 'vstore_id', 'goods_url', 'logined'));
        }

        //广告有设置外部链接，跳转
        if(! empty($info->url)){
            return Redirect::to($info->url);
        }
        return View::make('advertise.info')->with(compact('info'));
    }
}