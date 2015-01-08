<?php
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

/**
 * 企业后台-统计报表控制器
 *
 * @author jois
 */
class ReportController extends BaseController
{

    protected $platform_name = '指帮连锁';

    protected $trade_source = '支付宝担保交易';

    /**
     * 订单统计[销售概况]
     */
    public function getOrderList()
    {
        // 今日成交额&今日成交订单量
        $today = date('Y-m-d');
        $today_amount = $today_count = $yesterday_amount = $yesterday_count = 0;
        $today_order = Order::where('created_at', 'like', "{$today}%")->where('status', '<>', Order::STATUS_CANCEL)->get();
        foreach ($today_order as $item) {
            $today_amount += $item->amount;
            $today_count += $item->goods_count;
        }

        // 昨日成交额&昨日成交订单量
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $yesterday_order = Order::where('created_at', 'like', "{$yesterday}%")->where('status', '<>', Order::STATUS_CANCEL)->get();
        foreach ($yesterday_order as $item) {
            $yesterday_amount += $item->amount;
            $yesterday_count += $item->goods_count;
        }

        // 订单排行版
        $order = Order::with('store')->select(DB::raw('store_id,sum(amount) as sum_amount,sum(goods_count) as sum_goods_count'))->where('status', '<>', Order::STATUS_CANCEL);
        $order2 = Order::with('vstore')->select(DB::raw('vstore_id,sum(amount) as sum_amount,sum(goods_count) as sum_goods_count'))->where('status', '<>', Order::STATUS_CANCEL);
        // 过滤日期条件
        $date = [
            Input::get('start_date'),
            Input::get('end_date')
        ];
        sort($date);
        list ($start_date, $end_date) = $date;
        if (empty($start_date)) {
            // 本周一
            $start_date = date('Y-m-d', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 86400));
        }
        if (empty($end_date)) {
            // 本周日
            $end_date = date('Y-m-d', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 86400));
        }
        // 因为直接拿去between，所以多加一天
        $end_date = date('Y-m-d', strtotime($end_date) + 86400);

        $start_date2 = $start_date;
        $end_date2 = $end_date;

        // 过滤门店条件
        if (Input::has('store_id')) {
            $order->whereStoreId(Input::get('store_id'));
        }

        // 门店的结果
        $order = $order->whereBetween('created_at', array(
            $start_date,
            $end_date
        ))
            ->groupBy('store_id')
            ->orderBy('sum_goods_count', 'desc')
            ->paginate(Input::get('limit', 10));

        // 所有门店
        $stores = Store::orderBy('name', 'desc')->get();

        // 指店的结果
        $order2 = $order2->whereBetween('created_at', array(
            $start_date2,
            $end_date2
        ))
            ->groupBy('vstore_id')
            ->orderBy('sum_goods_count', 'desc')
            ->paginate(Input::get('limit', 10));

        $yesterday_amount = round($yesterday_amount, 2);
        $today_amount = round($today_amount, 2);

        // 返回视图
        return View::make('report.order-list')->with(compact('order', 'order2', 'stores', 'start_date', 'end_date', 'start_date2', 'end_date2', 'today_amount', 'today_count', 'yesterday_amount', 'yesterday_count'));
    }

    /**
     * 订单统计的明细[销售概况明细]
     */
    public function getOrderDetatil()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'store_id' => 'required|exists:store,id',
            'start_date' => 'required||date_format:Y-m-d',
            'end_date' => 'required||date_format:Y-m-d|after:' . Input::get('start_date')
        ], [
            'store_id.required' => '门店ID不能为空',
            'store_id.exists' => '门店不存在',
            'start_date.required' => '开始日期不能为空',
            'start_date.date_format' => '开始日期格式不正确',
            'end_date.date_format' => '结束日期格式不正确',
            'end_date.required' => '开始日期不能为空',
            'end_date.after' => '结束日期必须要大于开始日期'
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        $store_id = Input::get('store_id');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        // 获取订单ID
        $order_ids = Order::whereStoreId(Input::get('store_id'))->where('status', '<>', Order::STATUS_CANCEL)
            ->whereBetween('created_at', array(
            Input::get('start_date'),
            Input::get('end_date')
        ))
            ->lists('id');

        if (empty($order_ids)) {
            return View::make('report.order-detail');
        }
        $data = OrderGoods::with('order', 'goods.enterpriseGoods')->whereIn('order_id', $order_ids)->paginate(Input::get('limit', 10));

        return View::make('report.order-detail')->with(compact('data', 'store_id', 'start_date', 'end_date'));
    }

    /**
     * 指店的订单统计的明细[销售概况2]
     */
    public function getOrderDetatil2()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'vstore_id' => 'required|exists:vstore,id',
            'start_date' => 'required||date_format:Y-m-d',
            'end_date' => 'required||date_format:Y-m-d|after:' . Input::get('start_date')
        ], [
            'vstore_id.required' => '指店ID不能为空',
            'vstore_id.exists' => '指店不存在',
            'start_date.required' => '开始日期不能为空',
            'start_date.date_format' => '开始日期格式不正确',
            'end_date.date_format' => '结束日期格式不正确',
            'end_date.required' => '开始日期不能为空',
            'end_date.after' => '结束日期必须要大于开始日期'
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        $vstore_id = Input::get('vstore_id');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');

        // 获取订单ID
        $order_ids = Order::whereVstoreId(Input::get('vstore_id'))->where('status', '<>', Order::STATUS_CANCEL)
            ->whereBetween('created_at', array(
            Input::get('start_date'),
            Input::get('end_date')
        ))
            ->lists('id');
        if (empty($order_ids)) {
            return View::make('report.order-detail');
        }
        $data = OrderGoods::with('order', 'goods')->whereIn('order_id', $order_ids)->paginate(Input::get('limit', 10));
        return View::make('report.order-detail')->with(compact('data', 'vstore_id', 'start_date', 'end_date'));
    }

    /**
     * 用户统计分析
     */
    public function getMemberList()
    {
        $today = date('Y-m-d', time());

        // 验证输入
        $validator = Validator::make(Input::all(), [
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d|after:' . Input::get('start_date')
        ], [

            'start_date.date_format' => '开始日期格式不正确',
            'end_date.date_format' => '结束日期格式不正确',
            'end_date.after' => '结束日期必须要大于开始日期'
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        // 过滤日期条件
        if (Input::has('start_date') && Input::has('end_date')) {
            if (strtotime(Input::get('start_date')) > strtotime(Input::get('end_date'))) {
                $start_date = Input::get('end_date');
                $end_date = Input::get('start_date');
            } else {
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');
            }
        } elseif (Input::has('start_date')) {
            $start_date = Input::get('start_date');
            $end_date = $today;
        } elseif (Input::has('end_date')) {
            $start_date = date('Y-m-d', strtotime(Input::has('end_date')) - 7 * 86400);
            $end_date = Input::get('end_date');
        } else {
            // 前一周
            $start_date = date('Y-m-d', (time() - (7 * 86400)));
            $end_date = $today;
        }

        // 结束日期大于今天，将结束日期置为今天
        if ($end_date > $today) {
            $end_date = date('Y-m-d', (time()));
        }
        $days = intval((strtotime($end_date) - strtotime($start_date)) / 86400);

        $data = [];
        // 循环日期找出数据
        for ($i = 0; $i <= $days; $i ++) {
            $date = date('Y-m-d', strtotime($start_date) + ($i * 86400));
            $data[$i]['date'] = $date;
            $data[$i]['add_members'] = MemberInfo::where(DB::raw('substr(created_at,1,10)'), $date)->count();
            $data[$i]['total_members'] = MemberInfo::where(DB::raw('substr(created_at,1,10)'), '<=', $date)->count();
        }

        $data = array_reverse($data);

        // 返回视图
        return View::make('report.member-list')->withData($data);
    }

    /**
     * 货款报表
     */
    public function getStoreBrokerageList()
    {
        // 日期条件
        $date = [
            Input::get('start_date'),
            Input::get('end_date')
        ];
        sort($date);
        list ($start_date, $end_date) = $date;
        if (empty($start_date)) {
            // 前一周
            $start_date = date('Y-m-d', (time() - (7 * 86400)));
        }
        if (empty($end_date)) {
            // 今日
            $end_date = date('Y-m-d', (time() + 86400));
        }

        // 最终数据,货款算法：订单金额+指币金额(所需指币除于100)-佣金-退款金额
        $temp = Order::with('store.group', 'store.bankcard.bank')->select(DB::raw('sum(amount) as sum_amount,round(sum(amount+(use_coin/100)-brokerage-refund_amount)) as last_amount,store_id'))
            ->whereStatus(Order::STATUS_FINISH)
            ->whereBetween('finish_time', [
            $start_date,
            $end_date
        ])
            ->groupBy('store_id')
            ->orderBy('store_id', 'desc');

        // 总计金额
        $total_amount = $total_last_amount = 0;
        foreach ($temp->get() as $item) {
            $total_amount = $total_amount + $item->sum_amount;
            $total_last_amount = $total_last_amount + $item->last_amount;
        }
        $order = $temp->paginate(Input::get('limit', 10));

        return View::make('report.store-brokerage')->with(compact('order', 'start_date', 'end_date', 'total_amount', 'total_last_amount'));
    }

    /**
     * 全部导为银行报表
     */
    public function outStoreBrokerageToBankAll()
    {
        // 判断参数
        if (! Input::has('start_date') || ! Input::has('end_date')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '序号',
            '付款账户名称',
            '付款账号',
            '付款账户分行机构号',
            '收款账号',
            '收款账户名称',
            '收款账户分行机构号',
            '收款账户开户行名称',
            '收款账户开户行联行号',
            '收款账户会计柜台机构号',
            '收款账户行别标志',
            '金额',
            '币种',
            '用途'
        ];

        // 银行报表最多1000行数据
        $status = Input::get('status', 'All');
        $end_month = Input::get('end_month');
        $max_limit = 1000;

        // 企业绑定的银行卡数据源
        $enterprise_bankcard = Enterprise::find($this->enterprise_id)->bankcard;
        if (is_null($enterprise_bankcard)) {
            return Response::make('请企业先绑定银行卡', 402);
        }

        // 最终数据,货款算法：订单金额+指币金额(所需指币除于100)-佣金-退款金额
        $order = Order::with('store.group', 'store.bankcard.bank')->select(DB::raw('sum(amount) as sum_amount,round(sum(amount+(use_coin/100)-brokerage-refund_amount)) as last_amount,store_id'))
            ->whereStatus(Order::STATUS_FINISH)
            ->whereBetween('finish_time', [
            Input::get('start_date'),
            Input::get('end_date')
        ])
            ->groupBy('store_id')
            ->orderBy('store_id', 'desc')
            ->take($max_limit)
            ->get();

        foreach ($order as $key => $item) {
            $bankcard = $item->store->bankcard;
            if (is_null($bankcard)) {
                break;
            }
            // 判断指店绑定的银行是否和企业绑定的银行是同一个银行，比如建行
            $flag = "0";
            if ($bankcard->bank_id == $enterprise_bankcard->bank_id) {
                $flag = "1";
            }

            array_push($data, [
                ($key + 1),
                $enterprise_bankcard->name,
                $enterprise_bankcard->number,
                $enterprise_bankcard->branch_code,
                (string) $bankcard->number,
                (string) $bankcard->name,
                (string) $bankcard->branch_code,
                (string) $bankcard->branch_name,
                '', // 收款账户开户行联行号，跨行转账若此信息不填，该单据需落地进行补录处理
                '', // 收款账户会计柜台机构号
                (string) $flag,
                empty($item->last_amount) ? "0" : $item->last_amount,
                "01", // 币种，01代表人民币
                "门店货款"
            ]);
        }

        if (! empty($data)) {
            $excel_name = '银行报表' . time();
            $sheet_name = '指帮连锁门店货款银行报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('门店货款之银行报表');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);

                    // 设置粗体
                    $sheet->cells('A1:N1', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'A',
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I',
                        'J',
                        'K',
                        'L',
                        'M',
                        'N'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 部分导为银行报表
     */
    public function outStoreBrokerageToBankSome()
    {
        // 判断参数
        if (! Input::has('start_date') || ! Input::has('end_date') || ! Input::has('store_ids')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '序号',
            '付款账户名称',
            '付款账号',
            '付款账户分行机构号',
            '收款账号',
            '收款账户名称',
            '收款账户分行机构号',
            '收款账户开户行名称',
            '收款账户开户行联行号',
            '收款账户会计柜台机构号',
            '收款账户行别标志',
            '金额',
            '币种',
            '用途'
        ];

        // 银行报表最多1000行数据
        $store_ids = explode(',', Input::get('store_ids'));
        $status = Input::get('status', 'All');
        $end_month = Input::get('end_month');
        $max_limit = 1000;

        // 企业绑定的银行卡数据源
        $enterprise_bankcard = Enterprise::find($this->enterprise_id)->bankcard;
        if (is_null($enterprise_bankcard)) {
            return Response::make('请企业先绑定银行卡', 402);
        }

        // 最终数据,货款算法：订单金额+指币金额(所需指币除于100)-佣金-退款金额
        $order = Order::with('store.group', 'store.bankcard.bank')->select(DB::raw('sum(amount) as sum_amount,round(sum(amount+(use_coin/100)-brokerage-refund_amount)) as last_amount,store_id'))
            ->whereStatus(Order::STATUS_FINISH)
            ->whereIn('store_id', $store_ids)
            ->whereBetween('finish_time', [
            Input::get('start_date'),
            Input::get('end_date')
        ])
            ->groupBy('store_id')
            ->orderBy('store_id', 'desc')
            ->take($max_limit)
            ->get();

        foreach ($order as $key => $item) {
            $bankcard = $item->store->bankcard;
            if (is_null($bankcard)) {
                break;
            }
            // 判断指店绑定的银行是否和企业绑定的银行是同一个银行，比如建行
            $flag = "0";
            if ($bankcard->bank_id == $enterprise_bankcard->bank_id) {
                $flag = "1";
            }

            array_push($data, [
                ($key + 1),
                $enterprise_bankcard->name,
                $enterprise_bankcard->number,
                $enterprise_bankcard->branch_code,
                (string) $bankcard->number,
                (string) $bankcard->name,
                (string) $bankcard->branch_code,
                (string) $bankcard->branch_name,
                '', // 收款账户开户行联行号，跨行转账若此信息不填，该单据需落地进行补录处理
                '', // 收款账户会计柜台机构号
                (string) $flag,
                empty($item->last_amount) ? "0" : $item->last_amount,
                "01", // 币种，01代表人民币
                "门店货款"
            ]);
        }

        if (! empty($data)) {
            $excel_name = '银行报表' . time();
            $sheet_name = '指帮连锁门店货款银行报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('门店货款之银行报表');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);

                    // 设置粗体
                    $sheet->cells('A1:N1', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'A',
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I',
                        'J',
                        'K',
                        'L',
                        'M',
                        'N'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 门店货款明细【和Excel共用，所以独立出来】
     */
    protected function getStoreBroDetail($store_id = 0, $start_date = null, $end_date = null)
    {
        if ($store_id == 0 || is_null($start_date) || is_null($end_date)) {
            return Redirect::back()->withMessageError('门店、开始日期和结束日期中的参数为空，查找失败');
        }
        // 获取订单ID
        $order_ids = Order::whereStoreId($store_id)->where('status', Order::STATUS_FINISH)
            ->whereBetween('finish_time', array(
            $start_date,
            $end_date
        ))
            ->lists('id');
        if (empty($order_ids)) {
            return null;
        }
        $data = OrderGoods::with('order.member', 'goods')->whereIn('order_id', $order_ids);
        return $data;
    }

    /**
     * 门店货款明细
     */
    public function getStoreBrokerageDetail()
    {
        // 验证输入
        $validator = Validator::make(Input::all(), [
            'store_id' => 'required|exists:store,id',
            'start_date' => 'required||date_format:Y-m-d',
            'end_date' => 'required||date_format:Y-m-d|after:' . Input::get('start_date')
        ], [
            'store_id.required' => '门店ID不能为空',
            'store_id.exists' => '门店不存在',
            'start_date.required' => '开始日期不能为空',
            'start_date.date_format' => '开始日期格式不正确',
            'end_date.date_format' => '结束日期格式不正确',
            'end_date.required' => '开始日期不能为空',
            'end_date.after' => '结束日期必须要大于开始日期'
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()
                ->first())
                ->withInput();
        }

        $store_id = Input::get('store_id');
        $start_date = Input::get('start_date');
        $end_date = Input::get('end_date');
        $platform_name = $this->platform_name;
        $trade_source = $this->trade_source;

        // 数据源
        $data = $this->getStoreBroDetail($store_id, $start_date, $end_date);
        if (is_null($data)) {
            return View::make('report.store-brokerage-detail');
        }
        $data = $data->paginate(Input::get('limit', 10));

        return View::make('report.store-brokerage-detail')->with(compact('data', 'platform_name', 'trade_source', 'store_id', 'start_date', 'end_date'));
    }

    /**
     * 门店货款报表全部导出到Excel
     */
    public function exportStoreBrokerageExcel()
    {
        // 判断参数
        if (! Input::has('start_date') || ! Input::has('end_date') || ! Input::has('store_id')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '交易号',
            '订单号',
            '下单时间',
            '付款时间',
            '宝贝名称',
            '实付款',
            '佣金比',
            '佣金',
            '交易来源',
            '交易对方',
            '支付类型',
            '备注'
        ];

        // 数据源
        $goods = $this->getStoreBroDetail(Input::get('store_id'), Input::get('start_date'), Input::get('end_date'));
        $goods = $goods->get();

        // 所在门店
        $store = Store::find(Input::get('store_id'));
        if (is_null($store)) {
            return Response::make('门店不存在', 402);
        }
        $store_name = $store->name;
        $store_contacts = $store->contacts;

        // 总金额，货款及佣金比例
        $total = $total_rated = $rows = 0;
        foreach ($goods as $item) {
            $rows = $rows + 1;
            $rate = ($item->brokerage_ratio * (1 + $item->level_brokerage_ratio)) / 100;
            $brokerage = round(($item->quantity * $item->price * $rate), 2);
            array_push($data, [
                (string) $item->order->out_trade_no . ' ',
                (string) $item->order->id . ' ',
                (string) $item->order->created_at,
                $item->order->payment_time,
                $item->goods_name,
                round($item->price * $item->quantity, 2),
                ($rate * 100) . '%',
                $brokerage,
                $this->platform_name,
                $item->order->member->username,
                $this->trade_source,
                $item->goods_sku
            ]);

            // 订单总额
            $total = $total + ($item->price * $item->quantity);
            // 支付总额
            $total_rated = $total_rated + $brokerage;
        }
        if (! empty($data)) {
            $excel_name = time();
            $sheet_name = '指帮连锁财务报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name, $total, $total_rated, $rows, $store_name, $store_contacts)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('门店货款明细');

                $excel->sheet($sheet_name, function ($sheet) use($data, $total, $total_rated, $rows, $store_name, $store_contacts)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);
                    $sheet->prependRow(array(
                        '---------------------------------交易记录明细列表------------------------------------'
                    ));
                    $sheet->prependRow(array(
                        '起始日期:[' . Input::get('start_date') . ']    终止日期:[' . Input::get('end_date') . ']'
                    ));
                    $sheet->prependRow(array(
                        '门店名称：' . $store_name
                    ));
                    $sheet->prependRow(array(
                        '指帮连锁' . Enterprise::find($this->enterprise_id)->name . '交易记录明细查询'
                    ));
                    $sheet->prependRow(array(
                        '门店店主：' . $store_contacts
                    ));

                    $sheet->appendRow(array(
                        ''
                    ));
                    $sheet->appendRow(array(
                        '订单总额：￥' . $total
                    ));
                    $sheet->appendRow(array(
                        '佣金总额：￥' . $total_rated
                    ));
                    $sheet->appendRow(array(
                        '支付货款总额：￥' . round($total - $total_rated, 2)
                    ));

                    // 设置粗体
                    $sheet->cells('A6:J6', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A' . ($rows + 8), function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A' . ($rows + 9), function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A' . ($rows + 10), function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置合并行
                    $sheet->mergeCells('A5:F5');

                    // 设置固定宽度
                    $sheet->setWidth('A', 15);

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I'
                    ));

                    // 设置强制转化为Excel形式的字符串
                    // $sheet->setColumnFormat(array(
                    // 'A5:J5' => '@',
                    // 'A' => '@',
                    // 'B' => '@'
                    // ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 门店货款报表部分导出到Excel
     */
    public function exportStoreBrokerageExcel2()
    {
        if (! Input::has('order_goods_id') || ! Input::has('start_date') || ! Input::has('end_date') || ! Input::has('store_id')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '交易号',
            '订单号',
            '下单时间',
            '付款时间',
            '宝贝名称',
            '实付款',
            '佣金比',
            '佣金',
            '交易来源',
            '交易对方',
            '支付类型',
            '备注'
        ];

        // 所在门店
        $store = Store::find(Input::get('store_id'));
        if (is_null($store)) {
            return Response::make('门店不存在', 402);
        }
        $store_name = $store->name;
        $store_contacts = $store->contacts;

        $goods = OrderGoods::with('order.member', 'goods')->whereIn('id', explode(',', Input::get('order_goods_id')))->get();
        $total = $total_rated = $rows = 0;
        foreach ($goods as $item) {
            $rows = $rows + 1;
            $rate = ($item->brokerage_ratio * (1 + $item->level_brokerage_ratio)) / 100;
            $brokerage = round(($item->quantity * $item->price * $rate), 2);
            array_push($data, [
                (string) $item->order->out_trade_no . ' ',
                (string) $item->order->id . ' ',
                (string) $item->order->created_at,
                $item->order->payment_time,
                $item->goods_name,
                round($item->price * $item->quantity, 2),
                ($rate * 100) . '%',
                $brokerage,
                $this->platform_name,
                $item->order->member->username,
                $this->trade_source,
                $item->goods_sku
            ]);

            // 订单总额
            $total = $total + $item->price;
            // 支付总额
            $total_rated = $total_rated + $brokerage;
        }
        if (! empty($data)) {
            $excel_name = time();
            $sheet_name = '指帮连锁财务报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name, $total, $total_rated, $rows, $store_name, $store_contacts)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('门店货款明细');
                $excel->sheet($sheet_name, function ($sheet) use($data, $total, $total_rated, $rows, $store_name, $store_contacts)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);
                    $sheet->prependRow(array(
                        '---------------------------------交易记录明细列表------------------------------------'
                    ));
                    $sheet->prependRow(array(
                        '起始日期:[' . Input::get('start_date') . ']    终止日期:[' . Input::get('end_date') . ']'
                    ));
                    $sheet->prependRow(array(
                        '门店名称：' . $store_name
                    ));
                    $sheet->prependRow(array(
                        '指帮连锁' . Enterprise::find($this->enterprise_id)->name . '交易记录明细查询'
                    ));
                    $sheet->prependRow(array(
                        '门店店主：' . $store_contacts
                    ));

                    $sheet->appendRow(array(
                        ''
                    ));
                    $sheet->appendRow(array(
                        '订单总额：￥' . $total
                    ));
                    $sheet->appendRow(array(
                        '佣金总额：￥' . $total_rated
                    ));
                    $sheet->appendRow(array(
                        '支付货款总额：￥' . round($total - $total_rated, 2)
                    ));

                    // 设置粗体
                    $sheet->cells('A6:J6', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A' . ($rows + 8), function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A' . ($rows + 9), function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });
                    $sheet->cells('A' . ($rows + 10), function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置合并行
                    $sheet->mergeCells('A5:F5');

                    // 设置固定宽度
                    $sheet->setWidth('A', 15);

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I'
                    ));

                    // 设置强制转化为Excel形式的字符串
                    // $sheet->setColumnFormat(array(
                    // 'A5:J5' => '@',
                    // 'A' => '@',
                    // 'B' => '@'
                    // ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 指店统计分析
     */
    public function getVstoreList()
    {
        $today = date('Y-m-d', time());

        // 验证输入
        $validator = Validator::make(Input::all(), [
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d|after:' . Input::get('start_date')
        ], [

            'start_date.date_format' => '开始日期格式不正确',
            'end_date.date_format' => '结束日期格式不正确',
            'end_date.after' => '结束日期必须要大于开始日期'
        ]);
        if ($validator->fails()) {
            // 验证失败，返回错误信息。
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }

        // 过滤日期条件
        if (Input::has('start_date') && Input::has('end_date')) {
            if (strtotime(Input::get('start_date')) > strtotime(Input::get('end_date'))) {
                $start_date = Input::get('end_date');
                $end_date = Input::get('start_date');
            } else {
                $start_date = Input::get('start_date');
                $end_date = Input::get('end_date');
            }
        } elseif (Input::has('start_date')) {
            $start_date = Input::get('start_date');
            $end_date = $today;
        } elseif (Input::has('end_date')) {
            $start_date = date('Y-m-d', strtotime(Input::has('end_date')) - 7 * 86400);
            $end_date = Input::get('end_date');
        } else {
            // 前一周
            $start_date = date('Y-m-d', (time() - (7 * 86400)));
            $end_date = $today;
        }

        $store_id = [];

        // 过滤区域组织
        if (Input::has('group_id')) {
            $group_id = array_filter(Input::get('group_id'));
            $group_id = end($group_id);

            if (! empty($group_id)) {
                // 区域下所有子区域
                $groups = Group::find($group_id)->allSubGroups()->get();

                // 所有区域对应的门店id
                foreach ($groups as $group) {
                    $stores = Group::find($group->id)->stores()->get();
                    // 门店id
                    foreach ($stores as $store) {
                        $store_id[] = $store->id;
                    }
                }
            }
        }

        $days = intval((strtotime($end_date) - strtotime($start_date)) / 86400);

        $data = [];
        // 循环日期找出数据
        for ($i = 0; $i <= $days; $i ++) {
            $date = date('Y-m-d', strtotime($start_date) + ($i * 86400));
            $data[$i]['date'] = $date;

            // 新增指店
            $new_number = Vstore::where('status', Vstore::STATUS_OPEN)->where(DB::raw('substr(created_at,1,10)'), $date);

            if (! empty($store_id)) {
                $new_number->whereIn('store_id', $store_id);
            }
            $data[$i]['new_number'] = $new_number->count();

            // 累计指店
            $total_number = Vstore::where('status', Vstore::STATUS_OPEN)->where(DB::raw('substr(created_at,1,10)'), '<=', $date);

            if (! empty($store_id)) {
                $total_number->whereIn('store_id', $store_id);
            }
            $data[$i]['total_number'] = $total_number->count();
        }

        $data = array_reverse($data);

        $groups = Group::where('parent_path', '')->get();

        // 返回视图
        return View::make('report.vstore-list')->withData($data)->withGroups($groups);
    }

    /**
     * 指店佣金报表
     */
    public function getBrokerageList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => 'integer|between:1,200',
            'page' => 'integer|min:1',
            'end_month' => 'date_format:Y-m'
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0',
            'end_month.date_format' => '月份格式错误'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 本月多少天后可结算上月的佣金
        $can_settlement_brokerage_days = Configs::find('can_settlement_brokerage_days');
        if (is_null($can_settlement_brokerage_days)) {
            $can_settlement_brokerage_days = 15;
        }
        $can_settlement_brokerage_days = $can_settlement_brokerage_days->keyvalue;

        // 今日与其做对比，得出最高可查询月份，而月份参数优先级大于系统默认
        $today = (int) date('j');
        if ($today > $can_settlement_brokerage_days) {
            $max_month = date('Y-m', strtotime("-1 months"));
        } else {
            $max_month = date('Y-m', strtotime("-2 months"));
        }

        if (Input::has('end_month')) {
            $end_month = Input::get('end_month');
            if (strtotime($end_month) > strtotime($max_month)) {
                return Redirect::route('ReportBrokerageList')->withMessageError($end_month . '这个月份的佣金暂时还不能查询');
            }
        } else {
            $end_month = $max_month;
        }

        // 找出已经完成的订单商品，并且是没有退款退货的来进行结算佣金
        $limit = Input::get('limit', 15);
        $status = Input::get('status', 'All');

        if ($status == "ed") {
            // 已结算
            $data = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', '>', 0);
            })
                ->paginate($limit);
        } elseif ($status == "un") {
            // 未结算
            $data = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', 0);
            })
                ->paginate($limit);
        } elseif ($status == 'All') {
            // 全部
            $data = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%");
            })
                ->paginate($limit);
        } else {
            return View::make('report.brokerage')->withMessageError("结算状态错误");
        }

        return View::make('report.brokerage')->with(compact('end_month', 'max_month', 'data', 'limit', 'status'));
    }

    /**
     * 部分导出指店佣金记录到Excel
     */
    public function outExcelForVstoreBrokerageSome()
    {
        if (! Input::has('vstore_ids') || ! Input::has('end_month')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '序号',
            '指店名称',
            '店主名称',
            '所属门店',
            '开户户主姓名',
            '开户行',
            '银行账号',
            '佣金金额(￥)',
            '是否已结算'
        ];

        // 数据源
        $vstore_ids = explode(',', Input::get('vstore_ids'));
        $status = Input::get('status', 'All');
        $end_month = Input::get('end_month');
        if (Input::has('status') && $status == "un") {
            // 未结算
            $vstore = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', 0);
            })
                ->whereIn('id', $vstore_ids)
                ->get();
        } elseif (Input::has('status') && $status == "ed") {
            // 已结算
            $vstore = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', '>', 0);
            })
                ->whereIn('id', $vstore_ids)
                ->get();
        } else {
            // 全部
            $vstore = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%");
            })
                ->whereIn('id', $vstore_ids)
                ->get();
        }
        $bankcard_real_name = $bank_name = $bankcard_number = '';
        $js = '未结算';
        foreach ($vstore as $key => $item) {
            $yj = 0;
            foreach ($item->member->bankcards as $bankcard) {
                if ($bankcard->is_default == Bankcard::ISDEFAULT) {
                    $bankcard_real_name = $bankcard->real_name;
                    $bank_name = $bankcard->bank->name;
                    $bankcard_number = $bankcard->number;
                }
            }

            foreach ($item->orders as $order) {
                if ($order->status == Order::STATUS_FINISH && substr($order->finish_time, 0, 7) == $end_month) {
                    $yj = $yj + $order->brokerage;
                    if ($order->brokerage_settlement_id > 0) {
                        $js = '已结算';
                    }
                }
            }

            array_push($data, [
                ($key + 1),
                (string) $item->name,
                (string) empty($item->member->real_name) ? $item . member . username : $item->member->real_name,
                (string) $item->store->name,
                $bankcard_real_name,
                $bank_name,
                $bankcard_number . ' ',
                empty($yj) ? "0" : $yj,
                $js
            ]);
        }

        if (! empty($data)) {
            $excel_name = time();
            $sheet_name = '指帮连锁指店佣金报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('指店佣金');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);
                    $sheet->prependRow(array(
                        '月份:[' . Input::get('end_month') . ']'
                    ));

                    // 设置粗体
                    $sheet->cells('A3:I3', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置固定宽度
                    $sheet->setWidth('A', 15);

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 全部导出指店佣金记录到Excel
     */
    public function outExcelForVstoreBrokerageAll()
    {
        if (! Input::has('end_month')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '序号',
            '指店名称',
            '店主名称',
            '所属门店',
            '开户户主姓名',
            '开户行',
            '银行账号',
            '佣金金额(￥)',
            '是否已结算'
        ];

        // 数据源
        $status = Input::get('status', 'All');
        $end_month = Input::get('end_month');
        if (Input::has('status') && $status == "un") {
            // 未结算
            $vstore = Vstore::with('order', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', 0);
            })
                ->get();
        } elseif (Input::has('status') && $status == "ed") {
            // 已结算
            $vstore = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', '>', 0);
            })
                ->get();
        } else {
            // 全部
            $vstore = Vstore::with('orders', 'member.bankcards', 'store')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%");
            })
                ->get();
        }
        $bankcard_real_name = $bank_name = $bankcard_number = '';
        $yj = 0;
        $js = '未结算';
        foreach ($vstore as $key => $item) {
            foreach ($item->member->bankcards as $bankcard) {
                if ($bankcard->is_default == Bankcard::ISDEFAULT) {
                    $bankcard_real_name = $bankcard->real_name;
                    $bank_name = $bankcard->bank->name;
                    $bankcard_number = $bankcard->number;
                }
            }

            foreach ($item->orders as $order) {
                if ($order->status == Order::STATUS_FINISH && substr($order->finish_time, 0, 7) == $end_month) {
                    $yj = $yj + $order->brokerage;
                    if ($order->brokerage_settlement_id > 0) {
                        $js = '已结算';
                    }
                }
            }

            array_push($data, [
                ($key + 1),
                (string) $item->name,
                (string) empty($item->member->real_name) ? $item . member . username : $item->member->real_name,
                (string) $item->store->name,
                $bankcard_real_name,
                $bank_name,
                $bankcard_number . ' ',
                empty($yj) ? "0" : $yj,
                $js
            ]);
        }

        if (! empty($data)) {
            $excel_name = time();
            $sheet_name = '指帮连锁指店佣金报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('指店佣金');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);
                    $sheet->prependRow(array(
                        '月份:[' . Input::get('end_month') . ']'
                    ));

                    // 设置粗体
                    $sheet->cells('A3:I3', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置固定宽度
                    $sheet->setWidth('A', 15);

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 部分导出指店佣金记录到银行报表
     */
    public function outExcelToBankSome()
    {
        if (! Input::has('vstore_ids') || ! Input::has('end_month')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '序号',
            '付款账户名称',
            '付款账号',
            '付款账户分行机构号',
            '收款账号',
            '收款账户名称',
            '收款账户分行机构号',
            '收款账户开户行名称',
            '收款账户开户行联行号',
            '收款账户会计柜台机构号',
            '收款账户行别标志',
            '金额',
            '币种',
            '用途'
        ];

        // 银行报表最多1000行数据
        $status = Input::get('status', 'All');
        $end_month = Input::get('end_month');
        $vstore_ids = explode(',', Input::get('vstore_ids'));
        $max_limit = 1000;

        // 企业绑定的银行卡数据源
        $enterprise_bankcard = Enterprise::find($this->enterprise_id)->bankcard;
        if (is_null($enterprise_bankcard)) {
            return Response::make('请企业先绑定银行卡', 402);
        }

        if (Input::has('status') && $status == "un") {
            // 未结算
            $vstore = Vstore::with('orders', 'member.bankcards')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', 0);
            })
                ->whereIn('id', $vstore_ids)
                ->take($max_limit)
                ->get();
        } elseif (Input::has('status') && $status == "ed") {
            // 已结算
            $vstore = Vstore::with('orders', 'member.bankcards')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', '>', 0);
            })
                ->whereIn('id', $vstore_ids)
                ->take($max_limit)
                ->get();
        } else {
            // 全部
            $vstore = Vstore::with('orders', 'member.bankcards')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%");
            })
                ->whereIn('id', $vstore_ids)
                ->take($max_limit)
                ->get();
        }
        $bankcard_real_name = $bank_name = $bankcard_number = '';
        foreach ($vstore as $key => $item) {
            $yj = 0;
            foreach ($item->member->bankcards as $bankcard) {
                if ($bankcard->is_default == Bankcard::ISDEFAULT) {
                    $bankcard_real_name = $bankcard->real_name;
                    $bank_name = $bankcard->bank->name;
                    $bankcard_number = $bankcard->number;
                    $open_account_bank = $bankcard->open_account_bank;
                    // 判断指店绑定的银行是否和企业绑定的银行是同一个银行，比如建行
                    $flag = "0";
                    if ($bankcard->bank_id == $enterprise_bankcard->bank_id) {
                        $flag = "1";
                    }
                }
            }

            foreach ($item->orders as $order) {
                if ($order->status == Order::STATUS_FINISH && substr($order->finish_time, 0, 7) == $end_month) {
                    $yj = $yj + $order->brokerage;
                }
            }

            array_push($data, [
                ($key + 1),
                $enterprise_bankcard->name,
                $enterprise_bankcard->number,
                $enterprise_bankcard->branch_code,
                (string) $bankcard_number,
                (string) $bankcard_real_name,
                '',
                (string) $open_account_bank,
                '', // 收款账户开户行联行号，跨行转账若此信息不填，该单据需落地进行补录处理
                '', // 收款账户会计柜台机构号
                (string) $flag,
                empty($yj) ? "0" : $yj,
                "01", // 币种，01代表人民币
                "指店佣金"
            ]);
        }

        if (! empty($data)) {
            $excel_name = '银行报表' . time();
            $sheet_name = '指帮连锁指店银行报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('指店佣金之银行报表');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);

                    // 设置粗体
                    $sheet->cells('A1:N1', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'A',
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I',
                        'J',
                        'K',
                        'L',
                        'M',
                        'N'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 全部导出指店佣金记录到银行报表
     */
    public function outExcelToBankAll()
    {
        if (! Input::has('end_month')) {
            return Response::make('参数错误，导出失败', 402);
        }

        // Excel行首
        $data[] = [
            '序号',
            '付款账户名称',
            '付款账号',
            '付款账户分行机构号',
            '收款账号',
            '收款账户名称',
            '收款账户分行机构号',
            '收款账户开户行名称',
            '收款账户开户行联行号',
            '收款账户会计柜台机构号',
            '收款账户行别标志',
            '金额',
            '币种',
            '用途'
        ];

        // 银行报表最多1000行数据
        $status = Input::get('status', 'All');
        $end_month = Input::get('end_month');
        $max_limit = 1000;

        // 企业绑定的银行卡数据源
        $enterprise_bankcard = Enterprise::find($this->enterprise_id)->bankcard;
        if (is_null($enterprise_bankcard)) {
            return Response::make('请企业先绑定银行卡', 402);
        }

        // 指店银行卡信息
        if (Input::has('status') && $status == "un") {
            // 未结算
            $vstore = Vstore::with('orders', 'member.bankcards')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', 0);
            })
                ->take($max_limit)
                ->get();
        } elseif (Input::has('status') && $status == "ed") {
            // 已结算
            $vstore = Vstore::with('orders', 'member.bankcards')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%")
                    ->where('brokerage_settlement_id', '>', 0);
            })
                ->take($max_limit)
                ->get();
        } else {
            // 全部
            $vstore = Vstore::with('orders', 'member.bankcards')->whereHas('orders', function ($q) use($end_month)
            {
                $q->whereStatus(Order::STATUS_FINISH)
                    ->where('finish_time', 'like', "{$end_month}%");
            })
                ->take($max_limit)
                ->get();
        }
        $bankcard_real_name = $bank_name = $bankcard_number = '';
        $yj = 0;
        foreach ($vstore as $key => $item) {
            foreach ($item->member->bankcards as $bankcard) {
                if ($bankcard->is_default == Bankcard::ISDEFAULT) {
                    $bankcard_real_name = $bankcard->real_name;
                    $bank_name = $bankcard->bank->name;
                    $bankcard_number = $bankcard->number;
                    $open_account_bank = $bankcard->open_account_bank;
                    // 判断指店绑定的银行是否和企业绑定的银行是同一个银行，比如建行
                    $flag = "0";
                    if ($bankcard->bank_id == $enterprise_bankcard->bank_id) {
                        $flag = "1";
                    }
                }
            }

            foreach ($item->orders as $order) {
                if ($order->status == Order::STATUS_FINISH && substr($order->finish_time, 0, 7) == $end_month) {
                    $yj = $yj + $order->brokerage;
                }
            }

            array_push($data, [
                ($key + 1),
                $enterprise_bankcard->name,
                $enterprise_bankcard->number,
                $enterprise_bankcard->branch_code,
                (string) $bankcard_number,
                (string) $bankcard_real_name,
                '',
                (string) $open_account_bank,
                '', // 收款账户开户行联行号，跨行转账若此信息不填，该单据需落地进行补录处理
                '', // 收款账户会计柜台机构号
                (string) $flag,
                empty($yj) ? "0" : $yj,
                "01", // 币种，01代表人民币
                "指店佣金"
            ]);
        }

        if (! empty($data)) {
            $excel_name = '银行报表' . time();
            $sheet_name = '指帮连锁指店银行报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('指店佣金之银行报表');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);

                    // 设置粗体
                    $sheet->cells('A1:N1', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'A',
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I',
                        'J',
                        'K',
                        'L',
                        'M',
                        'N'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }

    /**
     * 佣金结算备注
     */
    public function postBrokerageSettlement()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'end_month' => 'required|date_format:Y-m',
            'remark' => 'required'
        ], [
            'end_month.required' => '月份不能为空',
            'end_month.date_format' => '月份格式不正确',
            'remark.required' => '结算备注不能为空'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $end_month = Input::get('end_month');
        // 保存结算记录
        $brokerage_settlement = new BrokerageSettlement();
        $brokerage_settlement->reckoner = Auth::id();
        $brokerage_settlement->remark = trim(Input::get('remark'));
        $brokerage_settlement->save();

        // 根据指店ID抓取对应定音，并遍历指店订单，更新订单结算状态
        if (Input::has('vstore_ids')) {
            $vstore_ids = explode(',', Input::get('vstore_ids'));
            $orders = Order::whereIn('vstore_id', $vstore_ids)->whereStatus(Order::STATUS_FINISH)
                ->where('finish_time', 'like', "{$end_month}%")
                ->where('brokerage_settlement_id', 0)
                ->get();
        } else {
            $orders = Order::whereStatus(Order::STATUS_FINISH)->where('finish_time', 'like', "{$end_month}%")
                ->where('brokerage_settlement_id', 0)
                ->get();
        }
        if ($orders->isEmpty()) {
            return Redirect::route('ReportBrokerageList')->withMessageError('没有数据得到更改');
        }

        foreach ($orders as $order) {
            $order->brokerage_settlement_id = $brokerage_settlement->id;
            $order->save();
        }

        return Redirect::route('ReportBrokerageList')->withMessageSuccess('添加结算备注成功');
    }

    /**
     * 指店佣金报表明细
     */
    public function getBrokerageDetail()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'vstore_id' => 'required|integer',
            'end_month' => 'required|date_format:Y-m'
        ], [
            'vstore_id.required' => '指店ID不能为空',
            'vstore_id.integer' => '指店ID必须是一个数字',
            'end_month.required' => '月份不能为空',
            'end_month.date_format' => '月份格式不正确'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $end_month = Input::get('end_month');
        $vstore_id = Input::get('vstore_id');
        $order_ids = Order::whereVstoreId($vstore_id)->whereStatus(Order::STATUS_FINISH)
            ->where('finish_time', 'like', "{$end_month}%")
            ->lists('id');
        if (empty($order_ids)) {
            return Redirect::route('ReportBrokerageList')->withMessageError('没有明细数据');
        }
        $data = OrderGoods::with('order.member')->whereIn('order_id', $order_ids)->paginate();

        return View::make('report.brokerage-detail')->with(compact('end_month', 'data', 'vstore_id'));
    }

    /**
     * 指店佣金明细全部导出到Excel
     */
    public function exportVstoreBrokerageExcel()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'end_month' => 'required|date_format:Y-m',
            'vstore_id' => 'required|integer'
        ], [
            'end_month.required' => '月份不能为空',
            'end_month.date_format' => '月份格式不正确',
            'vstore_id.required' => '指店ID不能为空',
            'vstore_id.integer' => '指店ID必须是一个数字'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // Excel行首
        $data[] = [
            '交易号',
            '订单号',
            '下单时间',
            '付款时间',
            '宝贝名称',
            '佣金(￥)',
            '交易来源',
            '交易对方',
            '支付类型',
            '备注'
        ];

        // 数据源
        $end_month = Input::get('end_month');
        $order_ids = Order::whereVstoreId(Input::get('vstore_id'))->whereStatus(Order::STATUS_FINISH)
            ->where('finish_time', 'like', "{$end_month}%")
            ->lists('id');
        if (empty($order_ids)) {
            return Response::make('没有数据可导出', 402);
        }
        $goods = OrderGoods::with('order.member')->whereIn('order_id', $order_ids)->get();
        foreach ($goods as $item) {
            array_push($data, [
                (string) $item->order->out_trade_no . ' ',
                (string) $item->order->id . ' ',
                (string) $item->order->created_at,
                $item->order->payment_time,
                $item->goods_name,
                round(($item->price * $item->quantity * $item->brokerage_ratio / 100), 2),
                $this->platform_name,
                $item->order->member->username,
                $this->trade_source,
                $item->goods_sku
            ]);
        }

        if (! empty($data)) {
            $excel_name = time();
            $sheet_name = '指帮连锁指店佣金明细报表(' . date("Y-m-d") . '导出)';
            Excel::create($excel_name, function ($excel) use($data, $sheet_name)
            {
                $excel->setTitle('指帮连锁');
                $excel->setCreator('smt-team')->setCompany('厦门速卖通');
                $excel->setDescription('指店佣金明细');

                $excel->sheet($sheet_name, function ($sheet) use($data)
                {
                    // 加入数据
                    $sheet->fromArray($data, null, 'A1', false, false);
                    $sheet->prependRow(array(
                        '月份:[' . Input::get('end_month') . ']'
                    ));

                    // 设置粗体
                    $sheet->cells('A3:J3', function ($cells)
                    {
                        $cells->setFont(array(
                            'bold' => true
                        ));
                    });

                    // 设置固定宽度
                    $sheet->setWidth('A', 15);

                    // 设置自适应宽度
                    $sheet->setAutoSize(array(
                        'B',
                        'C',
                        'D',
                        'F',
                        'G',
                        'H',
                        'I'
                    ));
                });
            })->export('xls');
        }

        return Response::make('没有数据导出，导出失败', 402);
    }
}
