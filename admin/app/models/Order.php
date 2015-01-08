<?php

/**
 * 订单模型
 *
 * @SWG\Model(id="Order", description="订单模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="member", type="Member",description="所属用户")
 * @SWG\Property(name="store", type="Store",description="所属门店")
 * @SWG\Property(name="vstore", type="Vstore",description="所属指店")
 * @SWG\Property(name="order_address", type="OrderAddress",description="收货地址")
 * @SWG\Property(name="amount", type="decimal",description="订单金额")
 * @SWG\Property(name="goods_count", type="integer",description="商品总数")
 * @SWG\Property(name="brokerage", type="float",description="订单佣金")
 * @SWG\Property(name="delivery",type="string", enum="['Electronic', 'Pickup']", description="交货方式")
 * @SWG\Property(name="status",type="string", enum="['PendingPayment', 'Cancel', 'PreparingForShipment', 'Processing', 'Shipped', 'ReadyForPickup','Finish']", description="订单状态")
 * @SWG\Property(name="commented",type="string", enum="['No', 'Yes']", description="评价状态")
 * @SWG\Property(name="out_trade_no",type="string", description="支付交易号")
 * @SWG\Property(name="payment_time",type="date-format", description="订单付款时间")
 * @SWG\Property(name="delivery_time",type="date-format", description="订单发货时间")
 * @SWG\Property(name="finish_time",type="date-format", description="订单结算时间")
 * @SWG\Property(name="use_coin",type="integer", description="使用指币数")
 * @SWG\Property(name="goods",type="OrderGoods", description="订单商品模型")
 * @SWG\Property(name="remark_buyer", type="string",description="买家备注")
 * @SWG\Property(name="remark_seller", type="string",description="卖家备注")
 * @SWG\Property(name="enrefund", type="string",enum="['Yes','No']",description="是否可退货退款")
 * @SWG\Property(name="can_again_refund", type="string",enum="['Yes','No']",description="是否再次退货退款[用于退款申请列表中，门店拒绝时的按钮为再次申请，Yes为再次申请]")
 * @SWG\Property(name="brokerage_settlement_id", type="integer",description="佣金结算ID,=0表示未结算,>0表示已结算")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Order extends Eloquent
{
    // 快递：待付款 > 取消订单
    // 快递：待付款 > 待发货 > 已发货 > 完成
    // 自提：待付款 > 取消订单
    // 自提：待付款 > 正在备货 > 随时可取 > 完成

    /**
     * 交货方式：电邮
     */
    const DELIVERY_ELECTRONIC = 'Electronic';

    /**
     * 交货方式：自取
     */
    const DELIVERY_PICKUP = 'Pickup';

    /**
     * 订单状态：待付款
     */
    const STATUS_PENDING_PAYMENT = 'PendingPayment';

    /**
     * 订单状态：初始
     */
    const STATUS_INIT = 'Init';

    /**
     * 订单状态：取消订单
     */
    const STATUS_CANCEL = 'Cancel';

    /**
     * 订单状态：待发货
     */
    const STATUS_PREPARING_FOR_SHIPMENT = 'PreparingForShipment';

    /**
     * 订单状态：已发货
     */
    const STATUS_SHIPPED = 'Shipped';

    /**
     * 订单状态：正在备货
     */
    const STATUS_PROCESSING = 'Processing';

    /**
     * 订单状态：随时可取
     */
    const STATUS_READY_FOR_PICKUP = 'ReadyForPickup';

    /**
     * 订单状态：完成
     */
    const STATUS_FINISH = 'Finish';

    /**
     * 订单状态：支付异常
     */
    const STATUS_ERROR = 'Error';

    /**
     * 买家评价：未评价
     */
    const COMMENTED_NO = 'No';

    /**
     * 买家评价：已评价
     */
    const COMMENTED_YES = 'Yes';



    protected $table = 'orders';

    public $incrementing = false;

    protected $primaryKey = 'id';

    protected $enrefund = [];

    protected $can_again_refund = [];

    protected $visible = [
        'id',
        'out_trade_no',
        'member',
        'goods',
        'store',
        'vstore',
        'orderAddress',
        'amount',
        'goods_count',
        'brokerage',
        'delivery',
        'payment_time',
        'delivery_time',
        'finish_time',
        'use_coin',
        'status',
        'commented',
        'remark_buyer',
        'remark_seller',
        'enrefund',
        'can_again_refund',
        'brokerage_settlement_id',
        'created_at'
    ];

    protected $appends = [
        'enrefund',
        'can_again_refund'
    ];

    public function __construct()
    {
        parent::__construct();

        // 自动生成订单ID。
        $this->attributes['id'] = uniqueid();
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            // 生成订单创建记录。
            $order_log = new OrderLog();
            $order_log->order_id = $model->id;
            $order_log->content = sprintf('%s 创建订单', Auth::user()->username);
            $order_log->original_status = 'Init';
            $order_log->current_status = $model->status;
            $order_log->save();
        });

        static::updated(function ($model)
        {
            // 如果订单的状态有更改则记录到订单操作记录表中。
            if ($model->isDirty('status')) {
                if ($model->status != Order::STATUS_CANCEL) {
                    // 取消订单需要传
                    $order_log = new OrderLog();
                    $order_log->order_id = $model->id;
                    $order_log->content = sprintf('订单状态从 %s 变更为 %s 。', Lang::get('order.status.' . $model->getOriginal('status')), Lang::get('order.status.' . $model->status));
                    $order_log->original_status = $model->getOriginal('status');
                    $order_log->current_status = $model->status;
                    $order_log->save();
                }

                // 如果为取消订单则加回订单中购买商品的数量。
                if ($model->status == Order::STATUS_CANCEL) {
                    // 获取订单的中商品列表
                    foreach ($model->goods as $order_goods) {
                        $goods_sku = explode('；', $order_goods->goods_sku);
                        $sku_key = [];
                        foreach ($goods_sku as $gs) {
                            $tmp = explode('：', $gs);
                            $sku_key[] = end($tmp);
                        }
                        // 生成库存规格key
                        $sku_key_str = implode(':', $sku_key);
                        // 判断是否存在此规格库存信息，如则修改其库存数量，没有则增加此规格的库存信息和规格属性
                        $stock_info = null;
                        foreach ($order_goods->goods->stocks as $stock) {
                            if (implode(':', $stock->sku_key) == $sku_key_str) {
                                $stock_info = $stock;
                                break;
                            }
                        }
                        if (empty($stock_info)) {
                            // 没有此规格库存则为商品加入此规格属性和规格库存
                            // 获取此商品的商品类别信息
                            $goods_type_attributes = GoodsTypeAttribute::where('goods_type_id', $order_goods->goods->goods_type_id)->get();
                            $sku_index = [];
                            foreach ($goods_type_attributes as $gak => $gav) {
                                // 判断是否存在此规格
                                if (array_key_exists($gak, $sku_key)) {
                                    $goodsAttribute = $order_goods->goods->goodsAttributes()
                                        ->where('goods_type_attribute_id', $gav->id)
                                        ->where('name', $sku_key[$gak])
                                        ->first();
                                    if (empty($goodsAttribute)) {
                                        $goodsAttribute = new GoodsAttribute();
                                        $goodsAttribute->goods_id = $order_goods->goods->id;
                                        $goodsAttribute->goods_type_attribute_id = $gav->id;
                                        $goodsAttribute->name = $sku_key[$gak];
                                        $goodsAttribute->save();
                                    }
                                    $sku_index[] = $goodsAttribute->id;
                                }
                            }
                            // 加入商品规格库存
                            $stock_info = new GoodsSku();
                            $stock_info->goods()->associate($order_goods->goods);
                            $stock_info->sku_key = implode(':', $sku_key);
                            $stock_info->sku_index = implode(':', $sku_index);
                            $stock_info->stock = $order_goods->quantity;
                            $stock_info->price = $order_goods->price;
                            $stock_info->save();
                        } else {
                            // 加回商品规格库存
                            $stock_info->increment('stock', $order_goods->quantity);
                        }
                        // 重新统计商品总库存
                        $order_goods->goods->stock = GoodsSku::where('goods_id', $order_goods->goods->id)->sum('stock');
                        $order_goods->goods->save();
                    }
                } else
                    if ($model->status == static::STATUS_FINISH) {
                        // 任务奖励
                        static::taskReward($model);
                    }

                // 订单完成，销售数量加订单中购买商品的数量。
                if ($model->status == Order::STATUS_FINISH) {
                    // 获取订单的中商品列表
                    $quantity = 0;
                    foreach ($model->goods as $order_goods) {
                        $order_goods->goods->increment('trade_quantity', $order_goods->quantity);
                        $order_goods->goods->enterpriseGoods->increment('trade_quantity', $order_goods->quantity);
                        $quantity += $order_goods->quantity;
                    }
                    $model->vstore->increment('trade_quantity', $quantity);
                    $model->vstore->increment('trade_order');
                    $model->vstore->increment('trade_amount', $model->amount - $model->refund_amount);
                }
            }
        });
    }

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属指店
     */
    public function vstore()
    {
        return $this->belongsTo('Vstore');
    }

    /**
     * 所属门店
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }

    /**
     * 订单商品
     */
    public function goods()
    {
        return $this->hasMany('OrderGoods');
    }

    /**
     * 订单记录
     */
    public function logs()
    {
        return $this->hasMany('OrderLog');
    }

    /**
     * 订单的收货地址
     */
    public function orderAddress()
    {
        return $this->hasOne('OrderAddress');
    }

    /**
     * 禁止修改订单ID
     */
    public function setIdAttribute($value)
    {
        // noop.
    }

    /**
     * 付款时间
     */
    public function getPaymentTimeAttribute()
    {
        if (empty($this->attributes['payment_time'])) {
            return '';
        }
        return $this->attributes['payment_time'];
    }

    /**
     * 订单结案时间
     */
    public function getFinishTimeAttribute()
    {
        if (empty($this->attributes['finish_time'])) {
            return '';
        }
        return $this->attributes['finish_time'];
    }

    /**
     * 发货时间
     */
    public function getDeliveryTimeAttribute()
    {
        if (empty($this->attributes['delivery_time'])) {
            return '';
        }
        return $this->attributes['delivery_time'];
    }

    /**
     * 是否可退款退货
     */
    public function getEnrefundAttribute()
    {
        if (empty($this->enrefund[$this->attributes['id']])) {
            if ($this->attributes['status'] == Order::STATUS_PREPARING_FOR_SHIPMENT || $this->attributes['status'] == Order::STATUS_SHIPPED || $this->attributes['status'] == Order::STATUS_PROCESSING || $this->attributes['status'] == Order::STATUS_READY_FOR_PICKUP) {
                return $this->enrefund[$this->attributes['id']] = 'Yes';
            }
            $enrefund_days = Configs::find('enrefund_days');
            if (is_null($enrefund_days)) {
                $enrefund_days = 7;
            }
            $enrefund_days = $enrefund_days->keyvalue;
            if ($this->attributes['status'] == Order::STATUS_FINISH) {
                if ((strtotime($this->attributes['finish_time']) + ($enrefund_days * 86400)) > time()) {
                    return $this->enrefund[$this->attributes['id']] = 'Yes';
                }
                return $this->enrefund[$this->attributes['id']] = 'No';
            }
            return $this->enrefund[$this->attributes['id']] = 'No';
        }
        return $this->enrefund[$this->attributes['id']];
    }

    /**
     * 当门店拒绝退款退货后，申请列表的按钮显示为“再次申请”
     */
    public function getCanAgainRefundAttribute()
    {
        if (empty($this->can_again_refund[$this->attributes['id']])) {
            if ($this->enrefund[$this->attributes['id']] == 'Yes') {
                $refund = Refund::whereOrderId($this->attributes['id'])->whereStatus(Refund::STATUS_STORE_REFUSE_BUYER)->first();
                if (! is_null($refund)) {
                    return $this->can_again_refund[$this->attributes['id']] = 'Yes';
                }
            }
            return $this->can_again_refund[$this->attributes['id']] = 'No';
        }
        return $this->can_again_refund[$this->attributes['id']];
    }

    /**
     * 任务奖励
     */
    protected static function taskReward($order)
    {
        // 查询之前是否已经做了此任务
        // 查询系统是否有这个任务
        $task = Task::where('status', Task::STATUS_OPEN)->find('buy_goods');
        $source = Source::find('buy_goods');
        $coin = null;
        $insource = null;
        if (! is_null($task) && Auth::check()) {
            $user = Auth::user();
            if ($task->cycle == Task::CYCLE_ONCE) {
                // 周期：一次性奖励
                // 查询之前是否已经做了此任务的指币记录
                $temp = Coin::whereMemberId($user->id)->whereKey($task->key)->first();
                if (is_null($temp)) {
                    // 添加指币记录
                    $coin = new Coin();
                    $coin->member()->associate($user);
                    // 无设置最高奖励限额时
                    if (empty($task->reward_coin)) {
                        $coin->amount = floor($order->amount - $order->refund_amount);
                    } else {
                        // 奖励的不能超过最高设置限额
                        $coin->amount = min($task->reward_coin, floor($order->amount - $order->refund_amount));
                    }
                    $coin->source()->associate($source);
                    $coin->save();
                }
                // 查询之前是否已经做了此任务的内购额记录
                $temp = Insource::whereMemberId($user->id)->whereKey($task->key)->first();
                if (is_null($temp)) {
                    // 添加内购额记录
                    $insource = new Insource();
                    $insource->member()->associate($user);
                    // 为购买商品时
                    // 无设置最高奖励限额时
                    if (empty($task->reward_insource)) {
                        $insource->amount = round($order->amount - $order->refund_amount, 2);
                    } else {
                        // 奖励的不能超过最高设置限额
                        $insource->amount = min($task->reward_insource, round($order->amount - $order->refund_amount, 2));
                    }
                    $insource->remark = "购买订单：{$order->id}的商品合计{$order->amount}元";
                    $insource->source()->associate($source);
                    $insource->save();
                }
            } elseif ($task->cycle == Task::CYCLE_EVERYDAY) {
                // 周期：每人每天
                // 今天此人此任务已经奖励指币多少次了
                $rewarded_times = Coin::whereMemberId($user->id)->whereKey($task->key)
                    ->where('created_at', 'like', date('Y-m-d') . '%')
                    ->count();
                if (empty($task->reward_times) || $task->reward_times > $rewarded_times) {
                    // 添加指币记录
                    $coin = new Coin();
                    $coin->member()->associate($user);
                    // 无设置最高奖励限额时
                    if (empty($task->reward_coin)) {
                        $coin->amount = floor($order->amount - $order->refund_amount);
                    } else {
                        // 奖励的不能超过最高设置限额
                        $coin->amount = min($task->reward_coin, floor($order->amount - $order->refund_amount));
                    }
                    $coin->source()->associate($source);
                    $coin->save();
                }
                // 今天此人此任务已经奖励内购额多少次了
                $rewarded_times = Insource::whereMemberId($user->id)->whereKey($task->key)
                    ->where('created_at', 'like', date('Y-m-d') . '%')
                    ->count();
                if (empty($task->reward_times) || $task->reward_times > $rewarded_times) {
                    // 添加指币记录
                    $insource = new Insource();
                    $insource->member()->associate($user);
                    // 无设置最高奖励限额时
                    if (empty($task->reward_insource)) {
                        $insource->amount = round($order->amount - $order->refund_amount, 2);
                    } else {
                        // 奖励的不能超过最高设置限额
                        $insource->amount = min($task->reward_insource, round($order->amount - $order->refund_amount, 2));
                    }
                    $insource->remark = "购买订单：{$order->id}的商品合计{$order->amount}元";
                    $insource->source()->associate($source);
                    $insource->save();
                }
            } elseif ($task->cycle == Task::CYCLE_NOCYCLE) {
                // 周期：不限制周期
                // 此任务已经奖励指币多少次了
                $rewarded_times = Coin::whereKey($task->key)->count();
                if (empty($task->reward_times) || $task->reward_times > $rewarded_times) {
                    // 添加指币记录
                    $coin = new Coin();
                    $coin->member()->associate($user);
                    // 无设置最高奖励限额时
                    if (empty($task->reward_coin)) {
                        $coin->amount = floor($order->amount - $order->refund_amount);
                    } else {
                        // 奖励的不能超过最高设置限额
                        $coin->amount = min($task->reward_coin, floor($order->amount - $order->refund_amount));
                    }
                    $coin->source()->associate($source);
                    $coin->save();
                }
                // 此任务已经奖励内购额多少次了
                $rewarded_times = Insource::whereKey($task->key)->count();
                if (empty($task->reward_times) || $task->reward_times > $rewarded_times) {
                    // 添加指币记录
                    $insource = new Insource();
                    $insource->member()->associate($user);
                    // 无设置最高奖励限额时
                    if (empty($task->reward_insource)) {
                        $insource->amount = round($order->amount - $order->refund_amount, 2);
                    } else {
                        // 奖励的不能超过最高设置限额
                        $insource->amount = min($task->reward_insource, round($order->amount - $order->refund_amount, 2));
                    }
                    $insource->remark = "购买订单：{$order->id}的商品合计{$order->amount}元";
                    $insource->source()->associate($source);
                    $insource->save();
                }
            }
        }
    }
}