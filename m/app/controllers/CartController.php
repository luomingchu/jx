<?php
/**
 * 购物车控制器
 */
class CartController extends BaseController
{
    protected $response;


    /**
     * 购物车
     */
    public function confirm()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'cart_id' => [
                    'required',
                    'exists:'. Config::get('database.connections.own.database') . '.carts,id'
                ]
            ],
            [
                'cart_id.required' => '购买商品信息错误！',
                'cart_id.exists' => '购买商品信息错误！',
            ]
        );

        if ($validator->fails()) {
            return View::make('message')->with('error_message', $validator->messages()->first());
        }

        Session::put('cart_id', Input::get('cart_id'));

        $goods = Auth::user()->cart()->with('vstore')->where('id', Input::get('cart_id'))->first();

        if ($goods->vstore->status != Vstore::STATUS_OPEN) {
            return View::make('message')->with('error_message', "当前指店已关闭，暂时不能购买！");
        }

        if (! empty($goods)) {

            // 应用活动信息
            $item = current(Event::fire('cart.check_activity', $goods));

            $cart_goods['info'] = $item->vstore;
            $cart_goods['goods_kind'] = 0;
            $cart_goods['goods_count'] = 0;
            $cart_goods['goods_amount'] = 0;
            $cart_goods['use_coin'] = 0;
            $cart_goods['use_insource'] = 0;
            $cart_goods['present_coin'] = 0;
            $cart_goods['present_insource'] = 0;
            $cart_goods['goods_list'] = [];

            $goods_sku = $item->goods_sku;
            $goods = $item->toArray();
            $goods['goods_sku'] = $goods_sku->toArray();
            $cart_goods['goods_list'][] = $goods;
            $cart_goods['goods_kind'] += 1;
            $cart_goods['use_coin'] += intval($item->use_coin);
            $cart_goods['use_insource'] += round($item->use_insource, 2);


            // 如果购买的数量超过了现有的库存则重置为现有的库存
            $quantity = $item->quantity;
            if ($quantity > $item->goods_sku->stock) {
                $quantity = $item->goods_sku->stock;
            }
            $cart_goods['goods_count'] += $quantity;
            $cart_goods['goods_amount'] += round($quantity * $item->goods_sku->price, 2);
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
            if (empty($task_info->reward_coin)) {
                $cart_goods['present_coin'] = floor($cart_goods['goods_amount']);
            } else {
                $cart_goods['present_coin'] = min($task_info->reward_coin, floor($cart_goods['goods_amount']));
            }
            if (empty($task_info->reward_insource)) {
                $cart_goods['present_insource'] = round($cart_goods['goods_amount'], 2);
            } else {
                $cart_goods['present_insource'] = min($task_info->reward_insource, round($cart_goods['goods_amount'], 2));
            }
        }

        // 获取用户收货地址
        if (Input::has('address_id')) {
            $address = Address::find(Input::get('address_id'));
        }
        empty($address) && $address = Address::where('type', Address::TYPE_RECEIPT)->where('member_id', Auth::user()->id)->orderBy('is_default', 'asc')->first();

        return View::make('goods.confirm')->with(compact('address', 'cart_goods'));
    }

    /**
     * 加入购物车
     */
    public function postAddCart()
    {
        if (! ($cart_info = $this->saveToCart())) {
            return Response::make($this->response, 402);
        }
        return $cart_info->id;
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
        if (empty($attention_vstore)) {
            $member_info = Auth::user()->info;
            $member_info->attention_vstore_id = Input::get('vstore_id');
            $member_info->save();
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

        $cart_info = Auth::user()->cart()
            ->where('vstore_id', Input::get('vstore_id'))
            ->where('goods_id', Input::get('goods_id'))
            ->where('sku_id', Input::get('goods_sku'))
            ->where('once', Cart::ONCE_VALID)
            ->first();

        if (empty($cart_info)) {
            $cart_info = new Cart();
            $cart_info->member()->associate(Auth::user());
            $cart_info->vstore()->associate($vstore);
            $cart_info->goods()->associate($goods_info);
            $cart_info->quantity = Input::get('quantity');
            $cart_info->sku_id = Input::get('goods_sku');
            $cart_info->once = Cart::ONCE_VALID;
            $cart_info->save();
        } else {
            $cart_info->quantity = Input::get('quantity');
            $cart_info->save();
        }
        return $cart_info;
    }
}