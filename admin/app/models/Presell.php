<?php

/**
 * 预售活动
 *
 * @SWG\Model(id="Presell", description="预售活动")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="start_settle_datetime", type="date-format",description="预售结款开始时间")
 * @SWG\Property(name="end_settle_datetime", type="date-format",description="预售结款结束时间")
 */
class Presell extends Eloquent
{



    protected $table = 'presell';

    protected $visible = [
        'id',
        'start_settle_datetime',
        'end_settle_datetime',
    ];

    public $timestamps = false;

    /**
     * 所属活动
     */
    public function activity()
    {
        return $this->morphMany('Activity', 'body');
    }
}
