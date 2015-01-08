<?php
/**
 * 门店处理买家退款控制器
 */
class RefundController extends BaseController
{

    /**
     * 获取退款申请列表
     */
    public function index()
    {
        // 获取当前门店的所有指店
//        $store_list = Store::all();

        // 获取区域列表
        $groups = Group::where('parent_path', '')->get();

        return View::make('refund.index')->with(compact('store_list', 'groups'));
    }

    /**
     * 获取退款申请列表
     */
    public function getRefundItems()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'start_date' => [
                    'date'
                ],
                'end_date' => [
                    'date'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        $list = Refund::with('member', 'goods', 'storeActivity', 'account')->latest();

        // 进行所属订单的准确搜索
        if (Input::has('order_id')) {
            $list->where('order_id', Input::get('order_id'));
        }

        // 进行退款单号准确搜索
        if (Input::has('refund_id')) {
            $list->where('id', Input::get('refund_id'));
        }

        // 进行商品名称搜索
        if (Input::has('goods_name')) {
            $list->where('goods_name', 'like', '%'.Input::get('goods_name').'%');
        }

        // 进行申请时间搜索
        $date = [];
        if (Input::has('start_date')) {
            $date['start_date'] = Input::get('start_date');
        } else {
            $date['start_date'] = '2000-1-1 00:00:00';
        }
        if (Input::has('end_date')) {
            $date['end_date'] = Input::get('end_date'). ' 23:59:59';
        } else {
            $date['end_date'] = date('Y-m-d H:i:s');
        }
        $list->whereBetween('created_at', $date);

        // 申请状态搜索
        if (Input::has('status')) {
            $list->where('status', Input::get('status'));
        } else {
            $list->whereIn('status', [Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT, Refund::STATUS_SUCCESS]);
        }

        $groups_id = array_filter(Input::get('group_id', []));
        // 销售门店搜索
        if (Input::has('vstore_id')) {
            $list->where('vstore_id', Input::get('vstore_id'));
        } else if (Input::has('store_id')) {
            $list->where('store_id', Input::get('store_id'));
        } else if (!empty($groups_id)) {
            // 进行区域搜索
            $groups = Group::whereIn('id', $groups_id)->get();
            foreach ($groups as $g) {
                $children = $g->ChildNodes()->get();
                if (! $children->isEmpty()) {
                    $groups_id = array_merge($groups_id, $children->modelKeys());
                }
            }
            $store_list = Store::whereIn('group_id', $groups_id)->get();
            if (! $store_list->isEmpty()) {
                $list->whereIn('store_id', $store_list->modelKeys());
            } else {
                $list = [];
            }
        }

        if (! empty($list)) {
            $list = $list->paginate(15)->appends(Input::all());
        }
        return View::make('refund.items')->with(compact('list'));
    }


    /**
     * 查看申请详情
     */
    public function getInfo($refund_id)
    {
        $info = Refund::with('order','goods', 'storeActivity', 'account', 'member', 'pictures', 'store.province', 'store.city', 'store.district', 'operations')->find($refund_id);

        // 标记退货、退货消息为已读
        Message::where('member_type', 'Enterprise')->where('specific', 'Refund')->where('body_id', $info->id)->update(['read' => Message::READ_YES]);

        return View::make('refund.info')->with(compact('info'));
    }


    /**
     * 确认退款
     */
    public function postAgreeRefundApply()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'refund_id' => [
                    'required',
                    'exists:refunds,id'
                ],
                'out_trade_no' => [
                    'required',
                ]
            ],
            [
                'refund_id.required' => '退款单号不能为空',
                'refund_id.exists' => '退款单号不存在',
                'out_trade_no.required' => '还款外单号不能为空'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $refund = Refund::find(Input::get('refund_id'));
        $refund->status = Refund::STATUS_SUCCESS;
        $refund->out_trade_no = Input::get('out_trade_no');
        $refund->append_content = Input::get('out_trade_no');
        $refund->save();

        // 修改订单退款总金额
        $order = Order::find($refund->order_id);
        $order->increment('refund_amount', $refund->refund_amount);
        $order->increment('refund_quantity', $refund->quantity);

        // 如果此订单的所有商品门店都同意退款，则此订单的状态为已关闭
        // 获取此订单的所有商品ID
        $order_goods_ids = $order->goods->modelKeys();
        // 获取此订单的所有退货的订单商品ID
        $refund_goods_ids = Refund::where('order_id', $refund->order_id)->where('status', Refund::STATUS_SUCCESS)->lists('order_goods_id');
        // 订单中商品都同意退款时，订单关闭
        $diff = array_diff($order_goods_ids, $refund_goods_ids);
        if (empty($diff)) {
            $order->status = Order::STATUS_CANCEL;
            $order->save();
        }

        // 返款通知
        Event::fire('refund.rebate', [$refund]);

        return $refund;
    }
}