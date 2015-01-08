<?php

/**
 * 客户订单控制器
 */
class OrderController extends BaseController
{

    protected $response = '';

    protected $orders = '';

    /**
     * 订单信息（M版）
     */
    public function MgetConfirm(){
        $cart_controller = new CartController();
        return View::make('order.confirm')->with([
            'data' => $cart_controller->index(),
        ]);
    }

    /**
     * 生成订单（M版）
     */
    public function postSubmit()
    {
        Unionpay::payment(date('YmdHis'), '100'); exit;
    }

    /**
     * 生成订单
     */
    public function postAdd()
    {
         /* Unionpay::payment(date('YmdHis'), '100');
         exit; */

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

        //银联付款告诉银联生成支付流水记录
        /* if(Input::get('payment') == 'unionpay'){
            Unionpay::paymentAPI($orders->out_trade_no, $order->amount);
        } */

        return $this->orders;
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

    /**
     * 订单列表
     */
    public function getBuyerList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'status' => [
                'in:' . join(',', [
                    Order::STATUS_PENDING_PAYMENT,
                    Order::STATUS_CANCEL,
                    Order::STATUS_PREPARING_FOR_SHIPMENT,
                    Order::STATUS_SHIPPED,
                    Order::STATUS_PROCESSING,
                    Order::STATUS_READY_FOR_PICKUP,
                    Order::STATUS_FINISH,
                    'Uncomment'
                ])
            ],
            'limit' => [
                'integer',
                'between:1,200'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得数据模型。
        $list = Auth::user()->orders()
            ->with('goods.goods', 'vstore')
            ->whereNull('buyer_deleted_at');

        // 处理筛选条件。
        if (Input::has('status')) {
            switch (Input::get('status')) {
                case Order::STATUS_PENDING_PAYMENT:
                case Order::STATUS_CANCEL:
                case Order::STATUS_PROCESSING:
                case Order::STATUS_READY_FOR_PICKUP:
                case Order::STATUS_FINISH:
                    $list->where('status', Input::get('status'));
                    break;

                // 待发货订单包含： 【快递待发货】与【自提备货中】 两个状态
                case Order::STATUS_PREPARING_FOR_SHIPMENT:
                    $list->where(function ($q)
                    {
                        $q->where('status', Input::get('status'))
                            ->orWhere('status', Order::STATUS_PROCESSING);
                    });
                    break;

                // 待收货订单包含： 【快递待收货】与【自提随时可取】 两个状态
                case Order::STATUS_SHIPPED:
                    $list->where(function ($q)
                    {
                        $q->where('status', Input::get('status'))
                            ->orWhere('status', Order::STATUS_READY_FOR_PICKUP);
                    });
                    break;

                case 'Uncomment':
                    $list->where('status', Order::STATUS_FINISH)->where('commented', Order::COMMENTED_NO);
                    break;
            }
        }

        // 返回单页数据。
        return $list->latest()
            ->paginate(Input::get('limit', 10))
            ->getCollection();
    }

    /**
     * 每个订单状态对应的数量
     */
    public function getOrderStatusNum()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'status' => [
                'in:' . join(',', [
                    Order::STATUS_PENDING_PAYMENT,
                    Order::STATUS_CANCEL,
                    Order::STATUS_PREPARING_FOR_SHIPMENT,
                    Order::STATUS_SHIPPED,
                    Order::STATUS_PROCESSING,
                    Order::STATUS_READY_FOR_PICKUP,
                    Order::STATUS_FINISH,
                    'Uncomment'
                ])
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得数据模型。
        $list = Order::whereMemberId(Auth::id())->whereNull('buyer_deleted_at');

        // 处理筛选条件。
        if (Input::has('status')) {
            switch (Input::get('status')) {
                case Order::STATUS_PENDING_PAYMENT:
                case Order::STATUS_CANCEL:
                case Order::STATUS_PROCESSING:
                case Order::STATUS_READY_FOR_PICKUP:
                case Order::STATUS_FINISH:
                    $list->where('status', Input::get('status'));
                    break;

                // 待发货订单包含： 【快递待发货】与【自提备货中】 两个状态
                case Order::STATUS_PREPARING_FOR_SHIPMENT:
                    $list->where(function ($q)
                    {
                        $q->where('status', Input::get('status'))
                            ->orWhere('status', Order::STATUS_PROCESSING);
                    });
                    break;

                // 待收货订单包含： 【快递待收货】与【自提随时可取】 两个状态
                case Order::STATUS_SHIPPED:
                    $list->where(function ($q)
                    {
                        $q->where('status', Input::get('status'))
                            ->orWhere('status', Order::STATUS_READY_FOR_PICKUP);
                    });
                    break;

                case 'Uncomment':
                    $list->where('status', Order::STATUS_FINISH)->where('commented', Order::COMMENTED_NO);
                    break;
            }
        }

        // 返回订单商品数量。
        // $count = 0;
        // foreach ($list->get() as $item) {
        // $count = $count + $item->goods()->count();
        // }

        // return $count;
        // 返回数量。
        return $list->count();
    }

    /**
     * 指店卖家订单列表
     */
    public function getSellerList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'status' => [
                'in:' . join(',', [
                    Order::STATUS_PENDING_PAYMENT,
                    Order::STATUS_CANCEL,
                    Order::STATUS_PREPARING_FOR_SHIPMENT,
                    Order::STATUS_SHIPPED,
                    Order::STATUS_PROCESSING,
                    Order::STATUS_READY_FOR_PICKUP,
                    Order::STATUS_FINISH,
                    'Uncomment'
                ])
            ],
            'limit' => [
                'integer',
                'between:1,200'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 取得数据模型。
        $list = Order::with('goods')->where('vstore_id', Auth::user()->vstore->id)
            ->with('goods.goods', 'vstore')
            ->whereNull('seller_deleted_at');

        // 处理筛选条件。
        if (Input::has('status')) {
            switch (Input::get('status')) {
                case Order::STATUS_PENDING_PAYMENT:
                case Order::STATUS_CANCEL:
                case Order::STATUS_PREPARING_FOR_SHIPMENT:
                case Order::STATUS_SHIPPED:
                case Order::STATUS_PROCESSING:
                case Order::STATUS_READY_FOR_PICKUP:
                case Order::STATUS_FINISH:
                    $list->where('status', Input::get('status'));
                    break;
                case 'Uncomment':
                    $list->where('status', Order::STATUS_FINISH)->where('commented', Order::COMMENTED_NO);
                    break;
            }
        }

        // 返回单页数据。
        return $list->latest()
            ->paginate(Input::get('limit', 10))
            ->getCollection();
    }

    /**
     * 订单详情
     */
    public function getDetail()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.orders,id'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取订单详情
        return Order::with('goods.goods', 'store', 'vstore', 'orderAddress', 'goods.comment')->find(Input::get('order_id'));
    }

    /**
     * 确认收货
     */
    public function postConfirmReceipt()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.orders,id,member_id,' . Auth::id()
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要处理的订单。
        $order = Order::find(Input::get('order_id'));

        // 只有已发货的订单才能进行收货确认
        if ($order->status != Order::STATUS_SHIPPED && $order->status != Order::STATUS_READY_FOR_PICKUP) {
            return Response::make('此订单还未发货，暂时不能确认收货。', 402);
        }

        // 用户收货确认
        $order->status = Order::STATUS_FINISH;
        $order->finish_time = new \Carbon\Carbon();
        $order->save();

        // 检查购买指店的等级
        Event::fire('order.vstore_upgrade', [
            $order
        ]);

        // 检查用户的等级
        Event::fire('order.member_upgrade', [
            $order
        ]);

        // 发送消息到指店
        Event::fire('messages.receipt_order', [
            $order
        ]);

        // 返回成功信息。
        return 'success';
    }

    /**
     * 用户取消订单
     */
    public function postCancelOrder()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.orders,id,member_id,' . Auth::id()
            ],
            'close_reason' => [
                'required'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要处理的订单。
        $order = Order::find(Input::get('order_id'));

        // 只有未付款的订单才能取消订单。
        if ($order->status != Order::STATUS_PENDING_PAYMENT) {
            return Response::make('只有未付款的订单才能取消。', 402);
        }

        // 取消订单
        $order->status = Order::STATUS_CANCEL;
        $order->save();

        // 发送消息到指店
        Event::fire('messages.cancel_order', [
            $order
        ]);

        // 加回用户内购额
        Event::fire('order.add_back_user_source', [
            $order,
            Auth::user()
        ]);

        // 返回成功信息。
        return 'success';
    }

    /**
     * 评价订单
     */
    public function postCommentOrder()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.orders,id,member_id,' . Auth::user()->id
            ],
            'anonymous' => [
                'in:' . join(',', [
                    GoodsComment::ANONYMOUS_ENABLE,
                    GoodsComment::ANONYMOUS_UNABLE
                ])
            ],
            'evaluation' => [
                'required',
                'array'
            ],
            'content' => [
                'required',
                'array'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 取得要处理的订单。
        $order = Order::find(Input::get('order_id'));

        // 判断订单是否已经结束。
        if ($order->status != Order::STATUS_FINISH) {
            return Response::make('不能对未结束的订单进行评价。', 402);
        }

        // 判断是否已评价。
        if ($order->commented == Order::COMMENTED_YES) {
            return Response::make('订单已评价。', 402);
        }

        // 获取订单的商品列表
        $goods_items = $order->goods()
            ->with('goods')
            ->get();
        $goods_ids = $goods_items->fetch('id')->toArray();
        $evaluation = Input::get('evaluation');
        $content = Input::get('content');
        $evaluation_goods_id = array_keys($evaluation);
        $content_goods_id = array_keys($content);
        // 判断订单中的商品是否全部评价。
        if (count(array_diff($goods_ids, $evaluation_goods_id)) > 0 || count(array_diff($goods_ids, $content_goods_id)) > 0) {
            return Response::make('请评价订单中的所有商品后再进行提交', 402);
        }

        // 保存评价信息。
        foreach ($goods_items as $goods) {
            $goods_comment = new GoodsComment();
            $goods_comment->member()->associate(Auth::user());
            $goods_comment->orderGoods()->associate($goods);
            $goods_comment->goods()->associate($goods->goods);
            $goods_comment->anonymous = Input::get('anonymous', GoodsComment::ANONYMOUS_ENABLE);
            $goods_comment->evaluation = $evaluation[$goods->id];
            $goods_comment->content = $content[$goods->id];
            $goods_comment->save();
        }

        // 修改订单评价状态。
        $order->commented = Order::COMMENTED_YES;
        $order->save();

        // 返回成功信息。
        return 'success';
    }

    /**
     * 删除已完成交易流程的订单
     */
    public function postDeleteOrder()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.orders,id,member_id,' . Auth::id()
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要处理的订单。
        $order = Order::find(Input::get('order_id'));

        // 只有取消的订单和已完成交易（并已评价）的订单可以删除。
        if ($order->status != Order::STATUS_CANCEL && ($order->status != Order::STATUS_FINISH || $order->commented != Order::COMMENTED_YES)) {
            return Response::make('只有取消的订单或已经完成交易流程（并已评价）的订单才能删除', 402);
        }

        // 标记买家删除状态。
        $order->buyer_deleted_at = new Carbon\Carbon();
        $order->save();

        // 返回成功信息。
        return 'success';
    }

    /**
     * 获取退货退款中最高退款金额
     *
     * @author jois
     */
    public function getOrderGoodsInfo()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.order_goods,id'
            ]
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要处理的订单。
        $order_goods = OrderGoods::with('goods')->whereHas('order', function ($q)
        {
            $q->whereMemberId(Auth::id());
        })
            ->find(Input::get('order_goods_id'));
        if (is_null($order_goods)) {
            return Response::make('您查看的订单商品不存在', 402);
        }
        return $order_goods;
    }
}
