<?php
use Illuminate\Support\Facades\Redirect;

/**
 * 订单管理
 */
class OrderController extends BaseController
{

    // 订单列表
    public function index()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'exists:orders,id'
            ],
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
            'start_datetime' => 'date',
            'end_datetime' => 'date'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withMessageError($validator->messages()
                ->first());
        }
        // 取得数据模型。
        $list = Order::with('orderAddress', 'goods.refund');

        $flag = true;

        //第一级组织区域
        $first_group_id = "";

        // 进行买家昵称搜索。
        if (Input::has('username')) {
            $list->whereHas('orderAddress', function($q) {
                $q->where('consignee', 'like', '%'.Input::get('username').'%');
            });
        }

        if ($flag) {
            // 处理筛选条件。
            if (Input::has('id')) {
                // 进行订单号精准匹配。
                $list = $list->where('id', Input::get('id'))->paginate(1);
            } else {
                // 进行时间搜索。
                if (Input::has('start_datetime')) {
                    $list->where('created_at', '>=', Input::get('start_datetime'));
                }
                if (Input::has('end_datetime')) {
                    $list->where('created_at', '<=', Input::get('end_datetime'));
                }

                // 进行状态搜索
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

                // 进行宝贝名称搜索
                if (Input::has('goods_name')) {
                    $list->whereHas('goods', function ($q)
                    {
                        $q->where('goods_name', "like", "%" . Input::get('goods_name') . "%");
                    });
                }

                // 进行销售指店搜索
                if (Input::has('vstore')) {
                    $list->where('vstore_id', Input::get('vstore'));
                } else if (Input::has('store')) {
                    $list = $list->where('store_id', Input::get('store'));
                }

                // 过滤区域组织
                if (Input::has('group_id')) {
                    $group_id = array_filter(Input::get('group_id'));
                    $parent_group_id = end($group_id);
                    $first_group_id = reset($group_id);

                    if (! empty($parent_group_id)) {

                        $store_id = array();

                        // 区域下所有子区域
                        $groups = Group::find($parent_group_id)->allSubGroups()->get();

                        // 所有区域对应的门店id
                        foreach ($groups as $group) {
                            $stores = Group::find($group->id)->stores()->get();
                            // 门店id
                            foreach ($stores as $store) {
                                $store_id[] = $store->id;
                            }
                        }

                        if (! empty($store_id)) {
                            $list = $list->whereIn('store_id', $store_id);
                        }
                    }
                }

                // 取出单页数据。
                $list = $list->latest()
                    ->paginate()
                    ->appends(Input::all());
            }
        } else {
            $list = [];
        }
        //获取组织区域
        $groups = Group::where('parent_path', '')->get();

        // 获取企业的所有门店列表
        $store_list = Store::all();
        return View::make('order.index')->with([
            'list' => $list,
            'store_list' => $store_list,
            'groups' => $groups,
            'first_group_id' => $first_group_id
        ]);
    }


    /**
     * 获取订单详情
     */
    public function getInfo($order_id)
    {
        $info = Order::with('goods.goods', 'store', 'Vstore', 'orderAddress', 'member', 'goods.comment')->find($order_id);
        return View::make('order.info')->with(compact('info'));
    }

}