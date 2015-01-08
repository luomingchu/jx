<?php

/**
 * 任务模型
 *
 * @SWG\Model(id="Task", description="任务模型")
 * @SWG\Property(name="key", type="string",description="主键索引")
 * @SWG\Property(name="source", type="Source",description="所属任务")
 * @SWG\Property(name="cycle",type="string", enum="['Once', 'Everyday', 'NoCycle']", description="任务奖励周期")
 * @SWG\Property(name="reward_coin",type="integer",description="一次的奖励指币数")
 * @SWG\Property(name="reward_insource",type="integer",description="一次的奖励内购额")
 * @SWG\Property(name="reward_times",type="integer",description="奖励次数")
 * @SWG\Property(name="remark",type="string",description="任务备注")
 * @SWG\Property(name="status",type="string", enum="['Open', 'Close']", description="是否开启任务")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Task extends Eloquent
{
    // 任务是否启用：启用
    const STATUS_OPEN = 'Open';
    // 任务是否启用：不启用
    const STATUS_CLOSE = 'Close';

    // 任务周期：一次性
    const CYCLE_ONCE = 'Once';
    // 任务周期：每天
    const CYCLE_EVERYDAY = 'EveryDay';
    // 任务周期：不限周期
    const CYCLE_NOCYCLE = 'NoCycle';



    protected $table = 'tasks';

    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $visible = [
        'key',
        'source',
        'cycle',
        'reward_coin',
        'reward_insource',
        'reward_times',
        'remark',
        'status',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::updated(function ($model)
        {});
    }

    /**
     * 所属来源
     */
    public function source()
    {
        return $this->belongsTo('Source', 'key', 'key');
    }

    /**
     * 购买商品奖励，对应可用的频道
     */
    public function channels()
    {
        return $this->belongsToMany('GoodsChannel', 'task_scope', 'task_key', 'goods_channel_id')->withTimestamps();
    }

    /**
     * 对奖励内购额是有小数点的进行保留两位数
     *
     * @return string
     */
    public function getRewardInsourceAttribute()
    {
        if (strpos($this->attributes['reward_insource'], '.')) {
            return sprintf('%.2f', $this->attributes['reward_insource']);
        } else {
            return $this->attributes['reward_insource'];
        }
    }
}