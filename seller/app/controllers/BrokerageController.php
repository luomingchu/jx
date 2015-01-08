<?php
/**
 * 佣金控制器
 */
class BrokerageController extends BaseController
{

    /**
     * 获取收益佣金明细记录
     */
    public function getIncomeList()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'status' => [
                    'in:Settled,Unsettled'
                ],
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

        $list = [];

        // 获取当前用户的指店
        $vstore = Auth::user()->vstore;
        if (! empty($vstore)) {
            $list = Order::with('goods.goods', 'vstore')->where('vstore_id', $vstore->id)->where('brokerage', '>', 0)->where('status', Order::STATUS_FINISH)->latest();

            if (Input::has('status')) {
                $status = Input::get('status', 'Settled');
                if ($status == 'Settled') {
                    $list->where('brokerage_settlement_id', '!=', 0);
                } else {
                    $list->where('brokerage_settlement_id', 0);
                }
            }
            $list = $list->paginate(Input::get('limit', 15))->getCollection();
        }

        return $list;
    }

    /**
     * 获取未结算和已结算佣金总额
     */
    public function getBrokerageAmount()
    {
        $vstore = Auth::user()->vstore;
        $data = [
            'settle' => 0,
            'unsettle' => 0
        ];
        if (! empty($vstore)) {
            $data['settle'] = round(Order::where('vstore_id', $vstore->id)->where('status', Order::STATUS_FINISH)->where('brokerage_settlement_id', '!=', 0)->sum('brokerage'), 2);
            $data['unsettle'] = round(Order::where('vstore_id', $vstore->id)->where('status', Order::STATUS_FINISH)->where('brokerage_settlement_id', 0)->sum('brokerage'), 2);
        }
        return $data;
    }
}