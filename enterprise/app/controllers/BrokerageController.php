<?php
/**
 * 佣金控制器
 */
class BrokerageController extends BaseController
{

    /**
     * 获取指店佣金列表
     */
    public function index()
    {
        // 获取其门店列表
        $stores = Store::all();

        return View::make('brokerage.index', compact('stores'));
    }

    /**
     * 获取佣金列表
     */
    public function getList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'limit' => [
                    'integer',
                    'min:1'
                ],
                'page' => [
                    'integer',
                    'min:1'
                ],
                'status' => [
                    'in:'.Brokerage::STATUS_SETTLED.','.Brokerage::STATUS_UNSETTLED
                ],
                'start_time' => 'date',
                'end_time' => 'date'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $list = Brokerage::with('order.goods.goods')->latest();

        // 指店过滤
        if (Input::has('vstore_id')) {
            $list->where('vstore_id', Input::get('vstore_id'));
        } else if (Input::has('store_id')) {
            // 门店过滤
            $list->whereHas('vstore', function($q)
            {
                $q->where('store_id', Input::get('store_id'));
            });
        }

        // 状态过滤
        if (Input::get('status')) {
            $list->where('status', Input::get('status'));
        }

        // 时间过滤
        if (Input::has('start_time')) {
            $list->where('created_at', '>=', Input::get('start_time'));
        }
        if (Input::has('end_time')) {
            $list->where('created_at', '<=', Input::get('end_time'));
        }

        $list = $list->paginate(Input::get('limit', 10));
        return View::make("brokerage.items")->with(compact('list'))->render();
    }

    /**
     * 确认结算佣金
     */
    public function postConfirmSettlementBrokerage()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'brokerage_id' => [
                    'required',
                    'exists:brokerages,id'
                ]
            ],
            [
                'brokerage_id.required' => '请选择要结算的订单',
                'brokerage_id.exists' => '系统找不到相关佣金记录'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取佣金信息
        $brokerageList = Brokerage::with('order.vstore')->where('status', Brokerage::STATUS_UNSETTLED)->whereIn('id', (array)Input::get('brokerage_id'))->get();

        if ($brokerageList->isEmpty()) {
            return Response::make('您选择的订单已结算过了', 402);
        }

        $vstore = [];
        $ids = [];
        foreach ($brokerageList as $item) {
            if (array_key_exists($item->order->vstore->id, $vstore)) {
                $vstore[$item->order->vstore->id]['amount'] += round($item->order_amount * $item->ratio / 100, 2);
            } else {
                $vstore[$item->order->vstore->id]['amount'] = round($item->order_amount * $item->ratio / 100, 2);
                $vstore[$item->order->vstore->id]['info'] = $item->order->vstore;
            }
            $ids[] = $item->id;
        }
        return ['brokerages' => implode(',', $ids), 'vstore' => array_values($vstore)];
    }


    /**
     * 结算佣金
     */
    public function postSettlementBrokerage()
    {
        $brokerage_id = explode(',', Input::get('brokerage_id'));
        $validator = Validator::make(
            compact('brokerage_id'),
            [
                'brokerage_id' => [
                    'required',
                    'exists:brokerages,id'
                ]
            ],
            [
                'brokerage_id.required' => '请选择要结算的订单',
                'brokerage_id.exists' => '系统找不到相关佣金记录'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取佣金信息
        $brokerageList = Brokerage::where('status', Brokerage::STATUS_UNSETTLED)->whereIn('id', $brokerage_id)->get();

        if ($brokerageList->isEmpty()) {
            return Response::make('您选择的订单已结算过了', 402);
        }

        $brokerage_id = [];
        $amount = 0;
        foreach ($brokerageList as $brokerage) {
            $brokerage_id[] = $brokerage->id;
            $amount += $brokerage->order_amount;
        }

        // 保存结算佣金记录
        $brokerage_settlement = new BrokerageSettlement();
        $brokerage_settlement->enterprise()->associate(Auth::user());
        $brokerage_settlement->brokerages = implode(',', $brokerage_id);
        $brokerage_settlement->amount = $amount;
        $brokerage_settlement->save();

        return 'success';
    }
}