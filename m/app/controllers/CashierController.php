<?php

/**
 * 付款控制器
 */
class CashierController extends BaseController
{

    // 异步通知地址
    protected $notify_url;

    // 回调通知地址
    protected $callback_url;


    /**
     * 付款
     */
    public function payment()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'payment_kind' => [
                    'required',
                    'in:alipay,unionpay'
                ],
                'order_id' => [
                    'required',
                    'exists:' . Config::get('database.connections.own.database') . '.orders,id,member_id,' . Auth::user()->id
                ]
            ],
            [
                'payment_kind.required' => '付款类型不能为空！',
                'payment_kind.in' => '选择的付款类型系统不支持！',
                'order_id.required' => '系统没有相关订单信息！',
                'order_id.exists' => '系统没有相关订单信息！'
            ]
        );

        if ($validator->fails()) {
            return View::make('message')->with('error_message', $validator->messages()->first());
        }

        // 获取订单信息
        $order = Order::find(Input::get('order_id'));

        // 判断是否是待付款状态
        if ($order->status != Order::STATUS_PENDING_PAYMENT) {
            return View::make('message')->with('error_message', "此订单已付款或已取消，不能进行付款操作！");
        }

        $kind = Input::get('payment_kind');

        // 设置回调地址和异步通知地址
        $this->callback_url = route(ucfirst("{$kind}Callback"));
        $this->notify_url = route(ucfirst("{$kind}Notify"));

        // 调用支付
        return call_user_func([$this, "{$kind}Payment"], $order);
    }


    /**
     * 支付宝付款
     */
    protected function alipayPayment($order)
    {
        return Alipaywap::payment($order->id, $order->amount, $this->notify_url, $this->callback_url, $order->remark_seller);
    }


    /**
     * 支付宝回调通知
     */
    public function alipayCallback()
    {
        $input = Input::all();
        // 验证通知结果
        if (Alipaywap::verify()) {
            if ($input['result'] == 'success' || $input['trade_status'] == 'TRADE_FINISHED' || $input['trade_status'] == 'TRADE_SUCCESS') {

                // 获取订单信息
                $order = Order::find($input['out_trade_no']);

                // 只修改待付款状态的订单
                if ($order->status == Order::STATUS_PENDING_PAYMENT) {

                    // 更新订单状态
                    $order->status = $order->delivery == Order::DELIVERY_ELECTRONIC ? Order::STATUS_PREPARING_FOR_SHIPMENT : Order::STATUS_PROCESSING;
                    $order->out_trade_no = $input['trade_no'];
                    $order->payment_time = new Carbon\Carbon();
                    $order->save();

                    $order = Order::find($order->id);
                    // 发送消息到指店，通知卖家客户买家成功付款订单
                    Event::fire('messages.payment_order', $order);
                }

                // 推荐商品
                $storeActivity = StoreActivity::where('store_id', $order->store_id)->where('status', StoreActivity::STATUS_OPEN)->where('end_datetime', '>', date('Y-m-d H:i:s'))->first();
                if (!empty($storeActivity)) {
                    $recommendation = Goods::whereIn('id', StoreActivitiesGoods::where('store_activity_id', $storeActivity->id)->orderByRaw("rand()")->take(4)->lists('goods_id'))->where('status', Goods::STATUS_OPEN)->get();
                    if ($recommendation->isEmpty()) {
                        $recommendation = Goods::where('status', Goods::STATUS_OPEN)->orderByRaw('rand()')->take(4)->get();
                    }
                }
                return View::make('cashier.callback')->with(compact('order', 'recommendation'));
            }
        }

        return View::make('message')->with('error_message', '订单支付出现异常，请联系指店店主！');
    }


    /**
     * 支付宝异步通知
     */
    public function alipayNotify()
    {
        $input = Input::all();

        // 解析返回的数据
        $xml = simplexml_load_string($input['notify_data']);
        if ($xml) {
            $notify_data = json_decode(json_encode($xml), 'json');
        }

        // 验证通知结果
        if (! empty($notify_data) && Alipaywap::verify()) {


            if ($notify_data['trade_status'] == 'TRADE_FINISHED' || $notify_data['result'] == 'success' || $notify_data['trade_status'] == 'TRADE_SUCCESS') {
                // 获取订单信息
                $order = Order::find($notify_data['out_trade_no']);

                // 只修改待付款状态的订单
                if ($order->status == Order::STATUS_PENDING_PAYMENT) {
                    // 更新订单状态
                    $order->status = $order->delivery == Order::DELIVERY_ELECTRONIC ? Order::STATUS_PREPARING_FOR_SHIPMENT : Order::STATUS_PROCESSING;
                    $order->out_trade_no = $notify_data['trade_no'];
                    $order->payment_time = new Carbon\Carbon();
                    $order->save();

                    $order = Order::find($order->id);

                    // 发送消息到指店，通知卖家客户买家成功付款订单
                    Event::fire('messages.payment_order', $order);
                }
            }
            echo 'success';
        }

        echo "fail";
    }


    /**
     * 银联支付
     */
    public function unionpayPayment($order)
    {
        echo '银联支付';
    }
}