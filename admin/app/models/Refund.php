<?php
use Illuminate\Database\Capsule\Manager;

/**
 * 退款退货模型
 *
 * @SWG\Model(id="Refund", description="退款退货模型")
 * @SWG\Property(name="id", type="string",description="主键索引")
 * @SWG\Property(name="member", type="Member",description="所属用户")
 * @SWG\Property(name="type",type="string",enum="['Money','Goods']", description="退款退货类型，Money-退款，Goods-退货")
 * @SWG\Property(name="order",type="Order",description="企业Logo")
 * @SWG\Property(name="store",type="Store",description="所属门店")
 * @SWG\Property(name="vstore",type="Vstore",description="所属门店")
 * @SWG\Property(name="status",type="string",enum="['wait_store_agree','store_refuse_buyer','wait_buyer_return_goods','wait_store_confirm_goods','wait_enterprise_repayment','success']", description="状态")
 * @SWG\Property(name="process_status",type="string",enum="['closed','success','progressing']", description="申请处理状态，closed:退款关闭，success:退款成功，processing:退款中")
 * @SWG\Property(name="orderGoods",type="OrderGoods", description="所属订单商品")
 * @SWG\Property(name="goods",type="Goods", description="所属商品")
 * @SWG\Property(name="goods_name",type="string", description="商品名称")
 * @SWG\Property(name="goods_sku",type="string", description="商品SKU")
 * @SWG\Property(name="price",type="string", description="商品单价")
 * @SWG\Property(name="quantity",type="integer", description="商品数量")
 * @SWG\Property(name="storeActivity",type="StoreActivity", description="所属门店活动")
 * @SWG\Property(name="refund_amount",type="decimal", description="退款金额")
 * @SWG\Property(name="account_id",type="integer", description="接收退款账户的支付宝ID或者银行卡ID")
 * @SWG\Property(name="account_type",type="string", description="接收退款账户的类型")
 * @SWG\Property(name="reason",type="string", description="退款原因")
 * @SWG\Property(name="remark",type="string", description="退款说明")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Refund extends Eloquent
{

    /**
     * 申请状态：退款/退货申请等待卖家确认中
     */
    const STATUS_WAIT_STORE_AGREE = 'wait_store_agree';

    /**
     * 申请状态：卖家不同意协议，拒绝退款/退货申请
     */
    const STATUS_STORE_REFUSE_BUYER = 'store_refuse_buyer';

    /**
     * 申请状态：退货申请达成，等待买家发货
     */
    const STATUS_WAIT_BUYER_RETURN_GOODS = 'wait_buyer_return_goods';

    /**
     * 申请状态：买家已退货,等待门店确认收货
     */
    const STATUS_WAIT_STORE_CONFIRM_GOODS = 'wait_store_confirm_goods';

    /**
     * 申请状态：等待企业还款
     */
    const STATUS_WAIT_ENTERPRISE_REPAYMENT = 'wait_enterprise_repayment';

    /**
     * 申请状态：申请成功
     */
    const STATUS_SUCCESS = 'success';

    /**
     * 申请类型：退款
     */
    const TYPE_MONEY = 'Money';

    /**
     * 申请类型：退货
     */
    const TYPE_GOODS = 'Goods';



    protected $table = 'refunds';

    public $incrementing = false;

    protected $appends = [
        'process_status'
    ];

    /**
     * 附加信息
     */
    protected static $append_content = '';

    public function __construct()
    {
        parent::__construct();

        // 自动生成订单ID。
        $this->attributes['id'] = uniqueid();
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            // 保存的时候自动生成唯一性ID。
            $model->id = uniqueid();
        });

        static::saved(function ($model)
        {
            // 生成退款退货记录
            $refund_log = new RefundLog();
            $refund_log->refund_id = $model->id;
            $content = '';
            $title = '';
            switch ($model->status) {
                case Refund::STATUS_WAIT_STORE_AGREE:
                    if ($model->type == Refund::TYPE_MONEY) {
                        $content = '买家要求：退款，商品状态：门店待发货待用户退款，退款金额：' . $model->refund_amount . '元，退款原因：' . $model->reason . '，';
                        $title = '创建了退款申请';
                    }
                    if ($model->type == Refund::TYPE_GOODS) {
                        $content = '买家要求：退货退款，商品状态：门店已发货待用户退货，退款金额：' . $model->refund_amount . '元，退款原因：' . $model->reason . '，';
                        $title = '创建了退货申请';
                    }
                    if (! empty($model->remark)) {
                        $content = $content . '退款说明：' . $model->remark . '，';
                    }
                    $content = $content . '退款编号：' . $model->id;
                    break;
                case Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT:
                    if ($model->type == Refund::TYPE_MONEY) {
                        $content = "卖家同意退款，退款金额 {$model->refund_amount}元\n退款编号：{$model->id}\n";
                        ! empty(static::$append_content) && $content .= "卖家符言：" . static::$append_content . "\n";
                        $content .= "将在1~3个工作日内处理退款申请!";
                        $title = "卖家同意退款，进行退款处理";
                    }
                    if ($model->type == Refund::TYPE_GOODS) {
                        $content = "卖家同意退货退款，退款金额 {$model->refund_amount}元\n退货退款编号：{$model->id}\n";
                        ! empty(static::$append_content) && $content .= "卖家符言：" . static::$append_content . "\n";
                        $content .= "将在1~3个工作日内处理退货退款申请!";
                        $title = "卖家已收到退货商品，进行退款处理";
                    }
                    break;
                case Refund::STATUS_STORE_REFUSE_BUYER:
                    $content = static::$append_content;
                    $title = $model->type == Refund::TYPE_MONEY ? "卖家不同意退款" : "卖家不同意退货退款";
                    break;
                case Refund::STATUS_WAIT_STORE_CONFIRM_GOODS:
                    $content = static::$append_content;
                    $title = "提交了退货物流信息";
                    break;
                case Refund::STATUS_WAIT_BUYER_RETURN_GOODS:
                    $content = "请按以下地址寄回商品：\n" . static::$append_content;
                    $title = "卖家同意退货";
                    break;
                case Refund::STATUS_SUCCESS:
                    $datetime = new Carbon\Carbon();
                    $content = "卖家同意退款，退款金额 {$model->refund_amount}元\n退款编号：{$model->id}\n处理时间：{$datetime}\n退款转账交易单号：" . static::$append_content;
                    $title = "卖家已退款";
                    break;
            }
            $refund_log->title = $title;
            $refund_log->content = $content;
            if (get_class(Auth::user()) == 'StoreManager' || get_class(Auth::user()) == 'Manager') {
                $refund_log->user()->associate(Vstore::find($model->vstore_id));
            } else {
                $refund_log->user()->associate(Member::find($model->member_id));

                // 发送消息给指店
                Event::fire('message.refund.to_vstore', array(
                    $model,
                    $refund_log
                ));

                // 发送消息给申请退款退货的消费者用户
                Event::fire('message.refund.to_member', array(
                    $model,
                    $refund_log
                ));
            }
            $original_status = $model->getOriginal('status');
            $refund_log->original_status = empty($original_status) ? RefundLog::STATUS_APPLY : $original_status;
            $refund_log->current_status = $model->status;
            $refund_log->save();
        });
    }

    /**
     * 申请人
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属订单
     */
    public function order()
    {
        return $this->belongsTo('Order');
    }

    /**
     * 所属门店
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }

    /**
     * 所属指店
     */
    public function vstore()
    {
        return $this->belongsTo('Vstore');
    }

    /**
     * 所属订单商品
     */
    public function orderGoods()
    {
        return $this->belongsTo('OrderGoods');
    }

    /**
     * 所属门店商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 所属门店活动
     */
    public function storeActivity()
    {
        return $this->belongsTo('StoreActivity');
    }

    /**
     * 退货、退款记录
     */
    public function operations()
    {
        return $this->hasMany('RefundLog');
    }

    /**
     * 申请图片列表
     */
    public function pictures()
    {
        return $this->belongsToMany('UserFile', 'refund_pictures', 'refund_id', 'picture_id');
    }

    /**
     * 收款账户
     */
    public function account()
    {
        return $this->morphTo();
    }

    /**
     * 设置附加留言信息
     */
    public function setAppendContentAttribute($content)
    {
        static::$append_content = $content;
    }

    /**
     * 获取退款状态
     */
    public function getProcessStatusAttribute()
    {
        if ($this->attributes['status'] == Refund::STATUS_STORE_REFUSE_BUYER) {
            return 'closed';
        } elseif ($this->attributes['status'] == Refund::STATUS_SUCCESS) {
            return 'success';
        } else {
            return 'progressing';
        }
    }

    /**
     * 禁止修改退款退货单号
     */
    public function setIdAttribute($value)
    {
        // noop.
    }
}