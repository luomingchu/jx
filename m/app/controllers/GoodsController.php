<?php
/**
 * 商品控制器
 */
class GoodsController extends BaseController
{

    /**
     * 查看商品详情
     */
    public function getInfo($goods_id = 0, $vstore_id = 0)
    {
        empty($goods_id) && $goods_id = Input::get('goods_id');
        empty($vstore_id) && $vstore_id = Input::get('vstore_id');
        if (empty($goods_id) || empty($vstore_id)) {
            return View::make('message')->with('error_message', '系统没有相关商品信息！');
        }

        // 获取商品信息
        $info = Goods::with('goodsAttributes', 'pictures')->find($goods_id);

        // 获取指店信息
        $vstore = Vstore::with('member', 'store')->where('status', Vstore::STATUS_OPEN)->find($vstore_id);

        if (empty($info) || empty($vstore)) {
            return View::make('message')->with('error_message', '系统没有相关商品信息！');
        }

        // 获取销售属性
        $attributes = [];
        foreach ($info->goods_attributes as $ga) {
            $attributes[$ga->attribute_index]['items'][] = $ga;
            $attributes[$ga->attribute_index]['name'] = $ga->attribute_name;
        }

        // 猜你喜欢
        $recommendation = Goods::where('id', '<>', $goods_id)->where('status', Goods::STATUS_OPEN)->where('store_id', $info->store_id)->orderByRaw("rand()")->take(6)->get();

        // 获取内购额比率
        $ratio_of_inner_purchase = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');
        empty($ratio_of_inner_purchase) && $ratio_of_inner_purchase = 100;

        // 判断是否已登录
        $logined = 0;
        if (Auth::check()) {
            $logined = 1;
        }

        $http_host = explode('.', Request::server('HTTP_HOST'));
        $http_host[1] = 'api';
        $http_host = implode('.', $http_host);
        $vstore_url = "http://{$http_host}/m/vstore/list?vstore_id={$vstore_id}";

        return View::make('goods.info')->with(compact('info', 'recommendation', 'ratio_of_inner_purchase', 'attributes', 'vstore', 'logined', 'vstore_url'));
    }
}