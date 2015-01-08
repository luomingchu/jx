<?php

/**
 * 购买商品任务奖励的频道范围模型
 *
 * @SWG\Model(id="TaskScope", description="购买商品任务奖励的频道范围模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="task", type="Task",description="所属任务")
 * @SWG\Property(name="channel",type="GoodsChannel",description="奖励的频道")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class TaskScope extends Eloquent
{



    protected $table = 'task_scope';

    protected $visible = [
        'id',
        'task',
        'channel',
        'created_at'
    ];

    protected $with = [
        'channel'
    ];

    /**
     * 所属任务【只为成功购买商品奖励的任务】
     */
    public function task()
    {
        return $this->belongsTo('Task');
    }

    /**
     * 所属频道【只为成功购买商品奖励的任务】
     */
    public function channel()
    {
        return $this->belongsTo('GoodsChannel');
    }
}