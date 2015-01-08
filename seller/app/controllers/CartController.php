<?php

/**
 * 购物车模块
 */
class CartController extends BaseController
{

    protected $item_list = [];

    protected $response;

    protected $shortcut = false;

    /**
     * 查看购物车
     */
    public function index($selected_cart_goods = [])
    {
        if ($this->shortcut) {
            $cart_goods_list = Auth::user()->cart()->where('once', Cart::ONCE_VALID)->with('vstore')->get();
        } else {
            $cart_goods_list = Auth::user()->cart()->where('once', Cart::ONCE_INVALID)->with('vstore')->get();
        }

        if (empty($selected_cart_goods)) {
            $selected_cart_goods = array_filter((array) Input::get('selected_cart_goods'));
        }

        // 如果有指定商品id,则只列出要购买的商品
        if (! empty($selected_cart_goods) && ! $cart_goods_list->isEmpty()) {
            $cart_goods_list = $cart_goods_list->filter(function ($cart) use($selected_cart_goods)
            {
                if (in_array($cart->id, $selected_cart_goods)) {
                    return true;
                }
                return false;
            });
        }
        $store_goods = [];
        if (! $cart_goods_list->isEmpty()) {
            foreach ($cart_goods_list as $k=>$item) {
                if ($item->vstore->status != Vstore::STATUS_OPEN  || is_null($item->goods_sku)) {
                    continue;
                }
                // 应用活动信息
                $item = current(Event::fire('cart.check_activity', $item));
                if (! array_key_exists($item->vstore->id, $store_goods)) {
                    $store_goods[$item->vstore->id]['info'] = $item->vstore;
                    $store_goods[$item->vstore->id]['goods_kind'] = 0;
                    $store_goods[$item->vstore->id]['goods_count'] = 0;
                    $store_goods[$item->vstore->id]['goods_amount'] = 0;
                    $store_goods[$item->vstore->id]['use_coin'] = 0;
                    $store_goods[$item->vstore->id]['use_insource'] = 0;
                    $store_goods[$item->vstore->id]['present_coin'] = 0;
                    $store_goods[$item->vstore->id]['present_insource'] = 0;
                    $store_goods[$item->vstore->id]['goods_list'] = [];
                }
                $goods_sku = $item->goods_sku;
                $goods = $item->toArray();
                $goods['goods_sku'] = $goods_sku->toArray();
                $store_goods[$item->vstore->id]['goods_list'][] = $goods;
                $store_goods[$item->vstore->id]['goods_kind'] += 1;
                $store_goods[$item->vstore->id]['use_coin'] += intval($item->use_coin);
                $store_goods[$item->vstore->id]['use_insource'] += round($item->use_insource, 2);
                // 如果购买的数量超过了现有的库存则重置为现有的库存
                $quantity = $item->quantity;
                if ($quantity > $item->goods_sku->stock) {
                    $quantity = $item->goods_sku->stock;
                }
                $store_goods[$item->vstore->id]['goods_count'] += $quantity;
                $store_goods[$item->vstore->id]['goods_amount'] += round($quantity * $item->goods_sku->price, 2);
            }
            $store_goods = array_values($store_goods);
        }
        // 获取系统设置的奖励指币和内购额
        $task_info = Task::where('key', 'buy_goods')->where('status', Task::STATUS_OPEN)->first();
        $flag = false;
        if (! empty($task_info)) {
            switch ($task_info->cycle) {
                // 当为单次时
                case Task::CYCLE_ONCE:
                    // 查询用户是否有支付的订单
                    $order = Order::where('member_id', Auth::user()->id)->where('status', '!=', Order::STATUS_PENDING_PAYMENT)->where('status', '!=', Order::STATUS_CANCEL)->first();
                    if (empty($order)) {
                        $flag = true;
                    }
                    break;
                case Task::CYCLE_EVERYDAY:
                    // 查询用户是否有支付的订单
                    $order = Order::where('member_id', Auth::user()->id)->where('status', '!=', Order::STATUS_CANCEL)->where('status', '!=', Order::STATUS_PENDING_PAYMENT)->where('created_at', '>=', date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 00:00:00')))->where('created_at', '<=', date('Y-m-d H:i:s', strtotime(date('Y-m-d').' 23:59:59')))->count();
                    if (empty($order) || empty($task_info->reward_times) || $order < $task_info->reward_times) {
                        $flag = true;
                    }
                    break;
                case Task::CYCLE_NOCYCLE:
                    $order = Order::where('member_id', Auth::user()->id)->where('status', '!=', Order::STATUS_CANCEL)->where('status', '!=', Order::STATUS_PENDING_PAYMENT)->count();
                    if (empty($order) || empty($task_info->reward_times) || $order < $task_info->reward_times) {
                        $flag = true;
                    }
                    break;
            }
        }
        if ($flag) {
            foreach ($store_goods as $k=>$store) {
                if (empty($task_info->reward_coin)) {
                    $store_goods[$k]['present_coin'] = floor($store['goods_amount']);
                } else {
                    $store_goods[$k]['present_coin'] = min($task_info->reward_coin, floor($store['goods_amount']));
                }
                if (empty($task_info->reward_insource)) {
                    $store_goods[$k]['present_insource'] = round($store['goods_amount'], 2);
                } else {
                    $store_goods[$k]['present_insource'] = min($task_info->reward_insource, round($store['goods_amount'], 2));
                }
            }
        }
        return $store_goods;
    }

    /**
     * 加入商品到购物车
     */
    protected function saveToCart()
    {
        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id'
            ],
            'goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods,id'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0'
            ],
            'goods_sku' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods_sku,id'
            ]
        ], [
            'vstore_id.required' => '购买的指店不能为空',
            'goods_id.required' => '商品不能为空',
            'goods_id.exists' => '商品不存在',
            'quantity.required' => '商品购买数量不能为空',
            'quantity.integer' => '商品购买数量必须是一个数字',
            'quantity.min' => '商品购买数量必须大于零',
            'goods_sku.required' => '请选择要购买商品的规格',
            'goods_sku.exists' => '相关商品中没有相关规格信息'
        ]);

        if ($validator->fails()) {
            $this->response = $validator->messages()->first();
            return false;
        }

        // 指店详情
        $vstore = Vstore::find(Input::get('vstore_id'));

        // 判断当前指店是否开店中
        if ($vstore->status != Vstore::STATUS_OPEN) {
            $this->response = "指店 {$vstore->name} 未开启，暂时不能购买";
            return false;
        }

        // 判断用户是否已经有关注此商品拥有的指店
        $attention_vstore = Auth::user()->info->attentionVstore;
        // 获取用户的指店
        $user_vstore = Auth::user()->vstore;
        if (! empty($user_vstore)) {
            $user_vstore = $user_vstore->id;
        }
        if (empty($attention_vstore) || $attention_vstore->id != $vstore->id) {
            if (empty($user_vstore) || $user_vstore != $vstore->id) {
                $this->response = '您还没有关注该指店，关注后才能购买';
                return false;
            }
        }

        $goods_info = Goods::find(Input::get('goods_id'));
        // 判断企业是否已下架此商品
        if ($goods_info->status != Goods::STATUS_OPEN) {
            $this->response = '此商品商家已下架，暂时不能购买';
            return false;
        }

        // 检查购买的商品库存
        $stock = $goods_info->stocks->keyBy('id')->get(Input::get('goods_sku'));
        if(is_null($stock)){
            $this->response = '商品不存在此型号。';
            return false;
        }
        if ($stock->stock < Input::get('quantity')) {
            $this->response = '库存不足，当前商品只剩' . $stock->stock.'件';
            return false;
        }

        // 判断用户可购买活动商品数量
        $buy_num = current(Event::fire('cart.check_join_activity_goods_num', [$vstore, $goods_info, Input::get('quantity'), Auth::user()]));
        $activity_quantity = current($buy_num);
        if ($activity_quantity < Input::get('quantity')) {
            $this->response = "此活动商品您已购买{$buy_num[1]}件，您还只能购买{$activity_quantity}件！";
            if (empty($buy_num[1])) {
                $this->response = "此活动商品单个用户只限购{$buy_num[2]}件！";
            }
            return false;
        }

        // 判断用户当前的内购额是否足够此商品允许的内购额
        $event_result = Event::fire('cart.check_user_insource', [$vstore, $goods_info, $stock, $activity_quantity, Auth::user()]);
        if (empty($event_result)) {
            $this->response = '您当前的内购额不足，暂时不能购买此商品';
            return false;
        }

        // 判断是否已经有购买了
        if ($this->shortcut) {
            $cart_info = Auth::user()->cart()
                ->where('vstore_id', Input::get('vstore_id'))
                ->where('goods_id', Input::get('goods_id'))
                ->where('sku_id', Input::get('goods_sku'))
                ->where('once', Cart::ONCE_VALID)
                ->first();
        } else {
            $cart_info = Auth::user()->cart()
                ->where('vstore_id', Input::get('vstore_id'))
                ->where('goods_id', Input::get('goods_id'))
                ->where('sku_id', Input::get('goods_sku'))
                ->where('once', Cart::ONCE_INVALID)
                ->first();
        }
        if (empty($cart_info)) {
            $cart_info = new Cart();
            $cart_info->member()->associate(Auth::user());
            $cart_info->vstore()->associate($vstore);
            $cart_info->goods()->associate($goods_info);
            $cart_info->quantity = Input::get('quantity');
            $cart_info->sku_id = Input::get('goods_sku');
            if ($this->shortcut) {
                $cart_info->once = Cart::ONCE_VALID;
            } else {
                $cart_info->once = Cart::ONCE_INVALID;
            }
            $cart_info->save();
        } else {
            if ($this->shortcut) {
                $cart_info->quantity = Input::get('quantity');
                $cart_info->save();
            } else {
                $cart_info->increment('quantity', Input::get('quantity'));
            }
        }
        return $cart_info;
    }


    /**
     * 加入到购物车
     */
    public function postAddToCart()
    {
        if (! $this->saveToCart()) {
            return Response::make($this->response, 402);
        }

        return Response::make('加入购物车成功');
    }

    /**
     * 立即购买
     */
    public function postBuy()
    {
        $this->shortcut = true;
        if (! ($cart_info = $this->saveToCart())) {
            return Response::make($this->response, 402);
        }
        $selected_cart_goods = (array) $cart_info->id;
        return $this->index($selected_cart_goods);
    }

    /**
     * 修改购物车中商品的数量
     */
    public function postUpdateQuantity()
    {
        $validator = Validator::make(Input::all(), [
            'cart_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.carts,id,member_id,' . Auth::user()->id
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $cart_info = Auth::user()->cart()->find(Input::get('cart_id'));

        // 指店详情
        $vstore = $cart_info->vstore;

        // 判断用户是否已经有关注此商品拥有的指店
        $attention_vstore = Auth::user()->info->attentionVstore;
        // 获取用户的指店
        $user_vstore = Auth::user()->vstore;
        if (! empty($user_vstore)) {
            $user_vstore = $user_vstore->id;
        }
        if (empty($attention_vstore) || $attention_vstore->id != $vstore->id) {
            if (empty($user_vstore) || $user_vstore != $vstore->id) {
                return Response::make('您还没有关注该指店，关注后才能购买', 402);
            }
        }

        $goods_info = $cart_info->goods;
        // 判断企业是否已下架此商品
        if ($goods_info->status != Goods::STATUS_OPEN) {
            return Response::make('此商品商家已下架，暂时不能购买', 402);
        }

        // 检查商品库存
        if ($cart_info->goodsSku->stock < Input::get('quantity')) {
            return Response::make('库存不足，当前商品只剩' . $cart_info->goodsSku->stock.'件', 402);
        }

        // 判断用户可购买活动商品数量
        $buy_num = current(Event::fire('cart.check_join_activity_goods_num', [$vstore, $goods_info, Input::get('quantity'), Auth::user()]));
        $activity_quantity = current($buy_num);
        if ($activity_quantity < Input::get('quantity')) {
            $this->response = "此活动商品您已购买{$buy_num[1]}件，您还只能购买{$activity_quantity}件！";
            if (empty($buy_num[1])) {
                $this->response = "此活动商品单个用户只限购{$buy_num[2]}件！";
            }
            return Response::make($this->response, 402);
        }

        // 判断用户当前的内购额是否足够此商品允许的内购额
        $event_result = Event::fire('cart.check_user_insource', [$vstore, $goods_info, $cart_info->goodsSku, $activity_quantity, Auth::user()]);
        if (empty($event_result)) {
            return Response::make('您当前的内购额不足，暂时不能购买此商品', 402);
        }

        // 修改商品的数量
        $cart_info->quantity = Input::get('quantity');
        $cart_info->save();

        return Response::make('购买商品数量修改成功');
    }



    /**
     * 修改购买的商品规格
     */
    public function postUpdateSku()
    {
        $validator = Validator::make(Input::all(), [
            'cart_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.carts,id,member_id,' . Auth::user()->id
            ],
            'goods_sku' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods_sku,id'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $cart_info = Auth::user()->cart()->find(Input::get('cart_id'));

        // 指店详情
        $vstore = $cart_info->vstore;

        // 判断用户是否已经有关注此商品拥有的指店
        $attention_vstore = Auth::user()->info->attentionVstore;
        // 获取用户的指店
        $user_vstore = Auth::user()->vstore;
        if (! empty($user_vstore)) {
            $user_vstore = $user_vstore->id;
        }
        if (empty($attention_vstore) || $attention_vstore->id != $vstore->id) {
            if (empty($user_vstore) || $user_vstore != $vstore->id) {
                return Response::make('您还没有关注该指店，关注后才能购买', 402);
            }
        }

        $goods_info = $cart_info->goods;
        // 判断是否已下架此商品
        if ($goods_info->status != Goods::STATUS_OPEN) {
            return Response::make('此商品商家已下架，暂时不能购买', 402);
        }

        // 检查指定的商品规格是否是此商品的规格
        $goods_sku_info = GoodsSku::find(Input::get('goods_sku'));
        if ($goods_sku_info->goods_id != $cart_info->goods->id) {
            return Response::make('此商品没有相关产品规格，请重新选择', 402);
        }
        // 检查商品库存
        if ($goods_sku_info->stock < $cart_info->quantity) {
            return Response::make('库存不足，当前规格只剩' . $goods_sku_info->stock.'件', 402);
        }

        // 判断用户当前的内购额是否足够此商品允许的内购额
        $event_result = Event::fire('cart.check_user_insource', [$vstore, $goods_info, $goods_sku_info, $cart_info->quantity, Auth::user()]);
        if (empty($event_result)) {
            return Response::make('您当前的内购额不足，暂时不能购买此商品', 402);
        }

        // 修改购买的商品规格
        // 如果已经有购买此规格的商品则直接商品,没有则修改为此规格
        if (Auth::user()->cart()
            ->where('vstore_id', $cart_info->vstore_id)
            ->where('goods_id', $cart_info->goods_id)
            ->where('sku_id', $cart_info->sku_id)
            ->where('id', '<>', Input::get('cart_id'))
            ->count() > 0) {
            $cart_info->delete();
        } else {
            $cart_info->sku_id = Input::get('goods_sku');
            $cart_info->save();
        }

        return Response::make('修改购买的商品规格成功');
    }


    /**
     * 删除购物车中的商品
     */
    public function postRemoveGoods()
    {
        $cart_id = array_filter(explode(',', Input::get('cart_id')));
        $validator = Validator::make(compact('cart_id'), [
            'cart_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.carts,id,member_id,' . Auth::user()->id
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取指定购物车中的商品信息
        foreach (Auth::user()->cart()
                     ->whereIn('id', $cart_id)
                     ->get() as $cart) {
            $cart->delete();
        }

        return Response::make('删除商品成功');
    }
}