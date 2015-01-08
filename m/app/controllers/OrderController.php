<?php
/**
 * 订单控制器
 */
class OrderController extends BaseController
{

    protected $response;

    /**
     * 生成订单
     */
    public function postAdd()
    {
        $input = Input::all();
        if (! is_array($input['cart_id'])) {
            $input['cart_id'] = array_filter(explode(',', $input['cart_id']));
        }
        // 验证输入。
        $validator = Validator::make($input, [
            'cart_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.carts,id,member_id,' . Auth::id()
            ],
            'delivery' => [
                'required',
                'in:' . join(',', [
                    Order::DELIVERY_ELECTRONIC,
                    Order::DELIVERY_PICKUP
                ])
            ],
            'address_id' => [
                'required_if:delivery,' . Order::DELIVERY_ELECTRONIC,
                'exists:address,id,type,' . Address::TYPE_RECEIPT . ',member_id,' . Auth::id()
            ],
            'use_coin' => [
                'in:True,False'
            ]
        ], [
            'cart_id.required' => '请选择要购买的商品，再进行提交。',
            'address_id.required_if' => '交货方式为电邮时，必须提供收货地址。',
            'address_id.exists' => '收货地址选择错误。',
            'delivery.required' => '请选择配送方式后，再进行提交。',
            'use_coin.in' => '使用指币参数错误'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 判断用户当前购物车中是否有此商品。
        $cart_goods_items = Cart::where('member_id', Auth::id())->with('vstore')
            ->whereIn('id', $input['cart_id'])
            ->get();
        // 检查可购买的商品
        $result = $this->checkGoodsValid($cart_goods_items);
        if (empty($result)) {
            return Response::make($this->response, 402);
        }

        $goods_list_group = [];
        // 订单总价格
        $use_coin = $result[1];
        // $amount = $result[2] - $use_coin/100;
        $amount = $result[2];
        $goods_count = 0;
        $brokerage = 0;
        $body = '购买：';
        // 指店等级佣金
        $levelBrokerageRatio = [];

        foreach ($cart_goods_items as $item) {
            $level_brokerage_ratio = 0;
            // 获取此商品的商品类别属性
            $goods_type_attribute = GoodsTypeAttribute::where('goods_type_id', $item->goods->goods_type_id)->orderBy('sort_order', 'asc')->get();
            // 生成完整的商品规格字符串
            $goods_sku = [];
            foreach ($item->goods_sku->sku_key as $sk => $sku) {
                if ($goods_type_attribute->has($sk)) {
                    $goods_sku[] = $goods_type_attribute->get($sk)->name . "：" . $sku;
                } else {
                    return Response::make('商家增加更改商品规格库存，暂时不能购买', 402);
                }
            }

            // 获取当前指店的佣金
            if (! isset($levelBrokerageRatio[$item->vstore_id])) {
                $levelBrokerageRatio[$item->vstore_id] = Vstore::with('vstoreLevel')->find($item->vstore_id);

                if ($levelBrokerageRatio[$item->vstore_id]->vstore_level) {
                    $level_brokerage_ratio = $levelBrokerageRatio[$item->vstore_id]->vstore_level->brokerage_ratio;
                }
            }

            // 对不同指店的商品分不同订单。
            if (! isset($goods_list_group[$item->vstore_id])) {
                $goods_list_group[$item->vstore_id] = [];
            }
            $price = $item->goods_sku->price;
            $store_activity_id = 0;
            $brokerage_ratio = $item->goods->brokerage_ratio;
            if (! empty($item->goods->activity)) {
                $price = round($price * $item->goods->activity['discount'] / 10, 2);
                $store_activity_id = $item->goods->activity['activity']['id'];
                $brokerage_ratio = $item->goods->activity['brokerage_ratio'];
            }
            $goods_list_group[$item->vstore_id][] = [
                'goods_id' => $item->goods->id,
                'goods_sku' => implode('；', $goods_sku),
                'price' => $price,
                'quantity' => $item->quantity,
                'goods_name' => $item->goods->name,
                'brokerage_ratio' => $brokerage_ratio,
                'store_activity_id' => $store_activity_id,
                'level_brokerage_ratio' => $level_brokerage_ratio
            ];

            // 统计总数量
            $goods_count += $item->quantity;
            // 统计总佣金
            $brokerage += round($item->quantity * $price * (($brokerage_ratio/100) * (1 + $level_brokerage_ratio/100)), 2);
            $body .= $item->goods->name . '；';
        }

        // 配送方式
        $delivery = Input::get('delivery');

        // 创建订单。
        $orders = [];

        foreach ($goods_list_group as $vstore_id => $goods_list) {
            // 取得订单所在的指店。
            $vstore = Vstore::find($vstore_id);
            // 生成订单
            $order = new Order();
            $order->member()->associate(Auth::user());
            $order->store()->associate($vstore->store);
            $order->vstore()->associate($vstore);
            $order->status = Order::STATUS_PENDING_PAYMENT;
            $order->amount = $amount;
            $order->use_coin = $use_coin;
            $order->goods_count = $goods_count;
            $order->delivery = $delivery;
            $order->remark_buyer = Input::get('memo', '');
            $order->remark_seller = $body;
            $order->brokerage = $brokerage;
            $order->save();

            // 保存订单收货地址
            $order_address = OrderAddress::createFromAddress(Input::get('address_id'));
            $order_address->order()->associate($order);
            $order_address->save();

            // 保存订单内商品列表。
            foreach ($goods_list as $goods) {
                $order_goods = new OrderGoods();
                $order_goods->order()->associate($order);
                $order_goods->goods_id = $goods['goods_id'];
                $order_goods->goods_sku = $goods['goods_sku'];
                $order_goods->price = $goods['price'];
                $order_goods->quantity = $goods['quantity'];
                $order_goods->goods_name = $goods['goods_name'];
                $order_goods->store_activity_id = $goods['store_activity_id'];
                $order_goods->brokerage_ratio = $goods['brokerage_ratio'];
                $order_goods->level_brokerage_ratio = $goods['level_brokerage_ratio'];
                $order_goods->save();
            }

            $orders[] = $order;
        }

        // 减掉相应商品规格中的商品库存。
        foreach ($cart_goods_items as $cart_info) {
            $cart_info->goods_sku->decrement('stock', $cart_info->quantity);
            $cart_info->goods->decrement('stock', $cart_info->quantity);
        }

        // 删除已生成订单的购物车商品
        Cart::whereIn('id', $cart_goods_items->fetch('id')->toArray())->delete();
        Session::forget('cart_id');

        $this->orders = $orders;

        // 减掉订单中所属商品需要的内购额
        Event::fire('order.deduct_user_source', [
            $orders,
            Auth::user()
        ]);

        // 发送消息的到对应的指店
        Event::fire('message.create_order', array(
            $this->orders
        ));

        return ['order_id' => current($this->orders)->id, 'payment_kind' => Input::get('payment_kind', 'alipay')];
    }


    /**
     * 获取购买的商品信息
     */
    protected function checkGoodsValid($cart_goods_items)
    {
        foreach ($cart_goods_items as $cart_info) {
            // 判断此商品是否已下架
            if ($cart_info->goods->status == Goods::STATUS_CLOSE) {
                $this->response = "商品：{$cart_info->goods->name}商家已下架，暂时不能购买";
                return false;
            }
            // 检查商品库存
            if ($cart_info->goods_sku->stock < $cart_info->quantity) {
                $this->response = "商品：{$cart_info->goods->name}库存不足，当前商品只剩{$cart_info->goods_sku->stock}件";
                return false;
            }
            // 检查活动信息
            $buy_num = current(Event::fire('cart.check_join_activity_goods_num', [
                $cart_info->vstore,
                $cart_info->goods,
                $cart_info->quantity,
                Auth::user()
            ]));
            $activity_quantity = current($buy_num);
            if (empty($activity_quantity)) {
                $this->response = $cart_info->goods->name . ' 购买的数量已达到此活动的最大限购数，暂时不能购买！';
                return false;
            } else
                if ($activity_quantity < $cart_info->quantity) {
                    if (empty($buy_num[1])) {
                        $this->response = "{$cart_info->goods->name} 此活动中只能购买{$activity_quantity}件！";
                    } else {
                        $this->response = "{$cart_info->goods->name} 您已购买{$buy_num[1]}件，您还只能购买{$activity_quantity}件！";
                    }
                    return false;
                }
        }
        // 检查用户的内购额是否足够购买此订单中的所有商品
        $event_result = Event::fire('order.check_user_source', [
            $cart_goods_items,
            Auth::user(),
            Input::get('use_coin', 'false')
        ]);
        if (empty($event_result)) {
            $this->response = '您没有足够的内购额购买此订单的所有商品';
            return false;
        }
        return current($event_result);
    }
}