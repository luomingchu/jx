<?php

/**
 * 聊天模型
 *
 * @SWG\Model(id="Chat", description="聊天模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="sender_user", type="Member",description="发送人")
 * @SWG\Property(name="receiver",type="integer",description="接收人ID")
 * @SWG\Property(name="kind",type="string", enum="['Text', 'Picture', 'Audio']", description="消息类型")
 * @SWG\Property(name="content",type="string", description="信息文本内容")
 * @SWG\Property(name="picture",type="UserFile",description="消息图片信息")
 * @SWG\Property(name="audio",type="UserFile", description="消息音频信息")
 * @SWG\Property(name="status", type="string", enum="['Read', 'Unread']", description="消息状态，Read:已读，Unread:未读")
 * @SWG\Property(name="unread_num", type="integer", description="未读新消息数")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Chat extends Eloquent
{

    /**
     * 消息类型：文本
     */
    const KIND_TEXT = 'Text';

    /**
     * 消息类型：图片
     */
    const KIND_PICTURE = 'Picture';

    /**
     * 消息类型：音频
     */
    const KIND_AUDIO = 'Audio';

    /**
     * 消息状态：已读
     */
    const STATUS_READ = 'Read';

    /**
     * 消息状态：未读
     */
    const STATUS_UNREAD = 'Unread';



    protected $table = 'chats';

    protected $visible = [
        'id',
        'sender_user',
        'receiver',
        'kind',
        'content',
        'picture',
        'audio',
        'status',
        'unread_num',
        'created_at'
    ];

    protected $appends = [
        'unread_num'
    ];

    protected $with = [
        'sender_user',
        'picture',
        'audio'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            // 推送到监控客户端
            static::pushMsg($model);
        });
    }

    /**
     * 消息发布者
     */
    public function sender_user()
    {
        return $this->belongsTo('Member', 'sender', 'id');
    }

    /**
     * 消息接受者
     */
    public function receiver_user()
    {
        return $this->belongsTo('Member', 'receiver', 'id');
    }

    /**
     * 关联图片
     */
    public function picture()
    {
        return $this->belongsTo('UserFile', 'picture_id');
    }

    /**
     * 关联的音频
     */
    public function audio()
    {
        return $this->belongsTo('UserFile', 'audio_id');
    }

    /**
     * 获取未读消息数
     */
    public function getUnreadNumAttribute()
    {
        static $unread = [];
        if (! isset($unread[$this->attributes['receiver']])) {
            if ($this->attributes['receiver'] == Auth::user()->id) {
                $unread[$this->attributes['receiver']] = Chat::where('sender', $this->attributes['sender'])->where('receiver', Auth::user()->id)
                    ->where('status', Chat::STATUS_UNREAD)
                    ->count();
            } else {
                $unread[$this->attributes['receiver']] = Chat::where('sender', $this->attributes['receiver'])->where('receiver', Auth::user()->id)
                    ->where('status', Chat::STATUS_UNREAD)
                    ->count();
            }
        }
        return $unread[$this->attributes['receiver']];
    }

    /**
     * 推送消息
     */
    protected static function pushMsg($model)
    {
        // 判断是否有相应的推送秘钥
        if (Config::get("baidupush::zb_circle.apiKey")) {
            // 选择百度推送的秘钥
            Bdpush::setKind("zb_circle");

            Bdpush::pushMessageByUid(self::find($model->id)->toArray(), Member::find($model->receiver), [
                'handler_type' => 'chat_message'
            ]);
        }
    }
}