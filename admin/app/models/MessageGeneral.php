<?php

/**
 * 常规消息
 *
 * @SWG\Model(id="MessageGeneral",description="常规消息")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="title",type="string",description="标题")
 * @SWG\Property(name="content",type="string",description="正文")
 */
class MessageGeneral extends Eloquent
{



    protected $table = 'message_general';

    public $timestamps = false;

    protected $visible = [
        'id',
        'title',
        'content'
    ];

    /**
     * 所属消息
     */
    public function message()
    {
        return $this->morphMany('Message', 'body');
    }
}