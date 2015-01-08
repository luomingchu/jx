<?php

/**
 * 广告模型
 *
 * @SWG\Model(id="Advertise", description="广告模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="title", type="string",description="广告标题")
 * @SWG\Property(name="picture", type="UserFile",description="广告图片")
 */
class Advertise extends Eloquent
{



    protected static $push_msg = '';

    /**
     * 状态：开启
     */
    const STATUS_OPEN = 'Open';

    /**
     * 状态：关闭
     */
    const STATUS_CLOSE = 'Close';

    /**
     * 类型：自定义广告
     */
    const KIND_CUSTOM = 'Custom';

    /**
     * 类型：商品广告
     */
    const KIND_GOODS = 'Goods';


    /**
     * the database table used by the model
     *
     * @var string
     */
    protected $table = 'advertises';

    protected $visible = [
        'id',
        'title',
        'picture'
    ];


    /**
     * 配置软件删除
     */
    use SoftDeletingTrait;

    protected $with = [
        'picture',
        'templatePicture'
    ];


    public static function boot()
    {
        parent::boot();

        static::saved(function ($model)
        {
            if ($model->status == static::STATUS_OPEN && ! empty(static::$push_msg)) {
                // 如果当前是运行的数据填充，则不进行消息推送。
                if (! App::runningInConsole()) {
                    // 判断是否有相应的推送秘钥
                    if (Config::get("baidupush::zb_circle.apiKey")) {
                        // 选择百度推送的秘钥
                        Bdpush::setKind("zb_circle");
                        Bdpush::broadcastMassage([
                            'id' => 0,
                            'member' => Member::first()->toArray(),
                            'member_type' => 'Member',
                            'read' => Message::READ_NO,
                            'type' => Message::TYPE_SYSTEM,
                            'specific' => Message::SPECIFIC_ADVERTISE,
                            'body_id' => $model->id,
                            'body_type' => $model->toArray(),
                            'description' => static::$push_msg,
                            'created_at' => date('Y-m-d H:i:s')
                        ], [
                            'handler_type' => 'notice_message'
                        ]);
                    }
                }
            }
        });
    }


    /**
     * 广告所在的广告位
     */
    public function space()
    {
        return $this->belongsTo('AdvertiseSpace');
    }

    /**
     * 广告图片
     */
    public function picture()
    {
        return $this->belongsTo('UserFile', 'picture_id');
    }

    /**
     * 模板图片
     */
    public function templatePicture()
    {
        return $this->belongsTo('UserFile', 'template_picture_id');
    }

    /**
     * 设置推送消息
     */
    public function setPushMsgAttribute($msg)
    {
        static::$push_msg = $msg;
    }
}

