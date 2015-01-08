<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Collection;

/**
 * 退款/退货退款控制器
 *
 * @author jois
 */
class RefundController extends BaseController
{

    /**
     * 可退款退货的订单列表
     */
    public function getRefundOrderList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => 'integer|between:1,200',
            'page' => 'integer|min:1'
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得数据模型。
        $list = Auth::user()->orders()
            ->with('goods.goods', 'vstore')
            ->whereNull('buyer_deleted_at');

        $data = new Collection();
        $list = $list->latest()->get();
        foreach ($list as $value) {
            if ($value->enrefund == 'Yes') {
                // 查询这个订单的退款退货ID
                $refund_ids = Refund::whereOrderId($value->id)->where('status', '<>', Refund::STATUS_STORE_REFUSE_BUYER)->lists('order_goods_id');
                if (! empty($refund_ids)) {
                    $temp = Order::with('goods.goods', 'vstore')->whereId($value->id)
                        ->whereHas('goods', function ($q) use ($refund_ids)
                    {
                        $q->whereNotIn('id', $refund_ids);
                    })
                        ->get();
                } else {
                    $temp = Order::with('goods.goods', 'vstore')->whereId($value->id)->get();
                }
                $data = $data->merge($temp);
            }
        }
        // 根据分页获取数据
        $limit = Input::get('limit', 10);
        $page = Input::get('page', 1);
        $start = $page == 1 ? 0 : $limit * ($page - 1);
        $end = $page == 1 ? $limit - 1 : ($limit * $page) - 1;
        foreach ($data as $key => $item) {
            if ($key < $start || $key > $end) {
                unset($data[$key]);
            }
        }
        return array_values($data->toArray());
    }

    /**
     * 获取退款、退货历史列表
     */
    public function getRefundList()
    {
        $refund = Refund::with('vstore.member.avatar', 'goods', 'orderGoods')->whereMemberId(Auth::id())
            ->latest()
            ->get();
        return $refund;
    }

    /**
     * 退货、退款日志列表,退款退货详情列表
     */
    public function getRefundLogList()
    {
        $validator = Validator::make(Input::all(), [
            'refund_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.refunds,id,member_id,' . Auth::id()
        ], [
            'refund_id.required' => '退款退货单号不能为空',
            'refund_id.exists' => '退款退货单不存在'
        ]);

        if ($validator->fails()) {
            Response::make($validator->messages()->first(), 402);
        }

        $refund_log = RefundLog::with('user')->whereRefundId(Input::get('refund_id'))
            ->oldest()
            ->get();

        return $refund_log;
    }

    /**
     * 申请退款
     */
    public function applyRefund()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'order_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.orders,id',
            'order_goods_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.order_goods,id,order_id,' . Input::get('order_id'),
            'type' => 'required|in:' . join(',', [
                Refund::TYPE_MONEY,
                Refund::TYPE_GOODS
            ]),
            'refund_amount' => 'required|numeric|min:0',
            'account_type' => 'required|in:AlipayAccount,Bankcard',
            'account_id' => 'required|integer|min:0',
            'reason' => 'required',
            'picture_id' => 'array|exists:user_files,id|user_file_mime:/^image\//i'
        ], [
            'order_id.required' => '订单ID不能为空',
            'order_id.exists' => '订单不存在',
            'order_goods_id.required' => '退款退货商品ID不能为空',
            'order_goods_id.exists' => '退款退货商品不存在',
            'type.required' => '退款退货类型不能为空',
            'type.in' => '退款退货类型只能在' . Refund::TYPE_MONEY . '和' . Refund::TYPE_GOODS . '之间进行选择',
            'refund_amount.required' => '退款金额不能为空',
            'refund_amount.numeric' => '退款金额必须是一个数字',
            'refund_amount.min' => '退款金额必须大于0',
            'account_type.required' => '接收退款账户类型不能为空',
            'account_type.in' => '接收退款账户类型必须是在支付宝和银行卡之间选择',
            'account_id.required' => '支付宝或者银行账户不能为空',
            'account_id.integer' => '支付宝或者银行账户ID只能为数字',
            'account_id.min' => '支付宝或者银行账户ID必须要大于0',
            'reason' => 'required',
            'picture_id.array' => '图片ID必须是一个数组参数',
            'picture_id.exists' => '图片ID不存在',
            'picture_id.user_file_mime' => '图片格式不正确'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 判断图片个数
        if (count(Input::get('picture_id')) > 3) {
            return Response::make('问题图片只能最多只能三张', 402);
        }

        // 判断订单状态
        $order = Order::find(Input::get('order_id'));
        if ($order->status == Order::STATUS_PREPARING_FOR_SHIPMENT || $order->status == Order::STATUS_SHIPPED || $order->status == Order::STATUS_FINISH || $order->status == Order::STATUS_PROCESSING || $order->status == Order::STATUS_READY_FOR_PICKUP) {
            // 当订单结案了，判断是否已经过了退款退货期限
            $temp = Configs::find('enrefund_days');
            if (is_null($temp)) {
                return Response::make('服务器错误，未设置订单可退货退款的有效期', 402);
            }
            $enrefund_days = $temp->keyvalue;

            if ($order->status == Order::STATUS_FINISH && date('Y-m-d', strtotime($order->finish_time)) < date('Y-m-d', strtotime("-{$enrefund_days} day"))) {
                return Response::make("您已经错过了申请售后的时间段(交易完成{$enrefund_days}天内)，换货或维修建议您和买家协商", 402);
            }

            // 判断账户信息
            if (Input::get('account_type') == 'AlipayAccount') {
                $account = AlipayAccount::find(Input::get('account_id'));
            }
            if (Input::get('account_type') == 'Bankcard') {
                $account = Bankcard::find(Input::get('account_id'));
            }
            if (is_null($account)) {
                return Response::make('接收退款的账户不存在', 402);
            }

            // 判断是否已经申请,
            $temp = Refund::where('status', '<>', Refund::STATUS_SUCCESS)->whereOrderGoodsId(Input::get('order_goods_id'))->first();
            if (is_null($temp)) {
                $order_goods = OrderGoods::find(Input::get('order_goods_id'));
                $refund = new Refund();
                $refund->member()->associate(Auth::user());
                $refund->type = Input::get('type');
                $refund->order_id = Input::get('order_id');
                $refund->store_id = $order->store_id;
                $refund->vstore_id = $order->vstore_id;
                $refund->status = Refund::STATUS_WAIT_STORE_AGREE;
                $refund->order_goods_id = Input::get('order_goods_id');
                $refund->goods_id = $order_goods->goods_id;
                $refund->goods_name = $order_goods->goods_name;
                $refund->goods_sku = $order_goods->goods_sku;
                $refund->price = $order_goods->price;
                $refund->quantity = $order_goods->quantity;
                $refund->store_activity_id = $order_goods->store_activity_id;
                $refund->refund_amount = Input::get('refund_amount');
                $refund->reason = Input::get('reason');
                if (Input::has('remark')) {
                    $refund->remark = Input::get('remark');
                }
                $refund->account()->associate($account);
                $refund->save();
                // 保存图片
                if (Input::has('picture_id')) {
                    $refund->pictures()->attach(Input::get('picture_id'));
                }

                // 消息通知指店、门店，买家提交了退货、退款申请
                Event::fire('refund.apply', [
                    $refund
                ]);

                return Refund::find($refund->id);
            }
            return Response::make('您已经申请了此笔退款退货或门店不同意您的退款退货申请，申请失败', 402);
        }
        return Response::make('退款退货只针对订单状态为待发货或已发货', 402);
    }

    /**
     * 退货物流信息填写接口
     */
    public function postAddress()
    {
        $validator = Validator::make(Input::all(), [
            'refund_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.refunds,id,member_id,' . Auth::id(),
            'ex_name' => 'required',
            'ex_number' => 'required'
        ], [
            'refund_id.required' => '退款退货单号不能为空',
            'refund_id.exists' => '退款退货单不存在',
            'ex_name.required' => '物流公司名称不能为空',
            'ex_number.required' => '物流快递单号不能为空'
        ]);

        if ($validator->fails()) {
            Response::make($validator->messages()->first(), 402);
        }

        // 更改状态并添加记录
        $refund = Refund::find(Input::get('refund_id'));
        if ($refund->status == Refund::STATUS_WAIT_BUYER_RETURN_GOODS) {
            $refund->status = Refund::STATUS_WAIT_STORE_CONFIRM_GOODS;
            $refund->append_content = "物流公司：" . Input::get('ex_name') . '，物流单号：' . Input::get('ex_number');
            $refund->save();

            return 'success';
        }
        return Response::make('退款单号状态错误，必须为退货申请达成，等待买家发货的状态才能填写物流信息', 402);
    }

    /**
     * 退货、退款消息推送
     */
    public function postMessage()
    {}
}