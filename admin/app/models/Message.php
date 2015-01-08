<?php

/**
 * 消息模型
 * @SWG\Model(id="Message",description="消息模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="member",type="Member",description="所属用户")
 * @SWG\Property(name="read",type="string",enum="['Yes', 'No']",description="读取状态")
 * @SWG\Property(name="type",type="string",enum="['Store','Community','System']",description="消息类型")
 * @SWG\Property(name="specific",type="string",enum="['Order','Answer','Accept','Follow','General','Sponsor', 'Common', 'Refund', 'Advertise']",description="具体分类")
 * @SWG\Property(name="description",type="string",description="消息标题")
 * @SWG\Property(name="body",type="morph",description="消息体模型")
 * @SWG\Property(name="body_type",type="string",description="消息体模型名")
 * @SWG\Property(name="created_at",type="date-format",description="发送时间")
 */
class Message extends Eloquent
{
    use SoftDeletingTrait;



    /**
     * 读取状态：已读
     */
    const READ_YES = 'Yes';

    /**
     * 读取状态：未读
     */
    const READ_NO = 'No';

    /**
     * 消息类型：指店消息
     */
    const TYPE_STORE = 'Store';

    /**
     * 消息类型：指帮消息
     */
    const TYPE_COMMUNITY = 'Community';

    /**
     * 消息类型：系统消息
     */
    const TYPE_SYSTEM = 'System';

    /**
     * 具体分类：订单
     */
    const SPECIFIC_ORDER = 'Order';

    /**
     * 具体分类：问题回答
     */
    const SPECIFIC_ANSWER = 'Answer';

    /**
     * 具体分类：回答被采纳
     */
    const SPECIFIC_ACCEPT = 'Accept';

    /**
     * 具体分类：请求加为好友
     */
    const SPECIFIC_FOLLOW = 'Follow';

    /**
     * 具体分类：常规系统消息
     */
    const SPECIFIC_GENERAL = 'General';

    /**
     * 具体分类：开店推荐人
     */
    const SPECIFIC_SPONSOR = 'Sponsor';

    /**
     * 具体分类：普通消息
     */
    const SPECIFIC_COMMON = 'Common';

    /**
     * 具体分类：退货、退款
     */
    const SPECIFIC_REFUND = 'Refund';

    /**
     * 具体分类：广告
     */
    const SPECIFIC_ADVERTISE = 'Advertise';

    /**
     * 是否已提醒：未提醒
     */
    const ALERT_NO = 'No';

    /**
     * 是否已提醒：已提醒
     */
    const ALERT_YES = 'Yes';

    protected $table = 'messages';

    /**
     * 是否推送消息
     */
    public static $push_message = true;

    protected $visible = [
        'id',
        'member',
        'read',
        'type',
        'specific',
        'description',
        'body',
        'body_type',
        'created_at'
    ];

    protected $with = [
        'body'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            // 如果当前是运行的数据填充，则不进行消息推送。
            if (! App::runningInConsole()) {

                // 判断是否有相应的推送秘钥
                if (static::$push_message && Config::get("baidupush::zb_circle.apiKey")) {
                    // 选择百度推送的秘钥
                    Bdpush::setKind("zb_circle");
                    // 当推送的用户为指店、会员时进行app消息推送
                    if ($model->member_type == 'Member') {
                        Bdpush::pushMessageByUid($model->toArray(), $model->member,[
                            'handler_type' => 'notice_message'
                        ]);
                    }
                }
            }
        });
    }

    /**
     * 接收者
     */
    public function member()
    {
        return $this->morphTo();
    }

    /**
     * 消息体
     */
    public function body()
    {
        return $this->morphTo();
    }
}