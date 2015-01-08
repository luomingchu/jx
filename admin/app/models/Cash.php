<?php

/**
 * 现金明细
 *
 * @author Latrell Chan
 *
 * @SWG\Model(id="Cash")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="amount",type="float",description="变更金额")
 * @SWG\Property(name="reason",type="string",description="原因")
 * @SWG\Property(name="type",type="string",enum="{'Income':'收入','Expense':'支出'}",description="类型")
 * @SWG\Property(name="created_at",type="date-format",description="时间")
 */
class Cash extends Eloquent
{

    /**
     * 变更类型：收入
     */
    const TYPE_INCOME = 'Income';

    /**
     * 变更类型：支出
     */
    const TYPE_EXPENSE = 'Expense';

    protected $table = 'cash';

    protected $visible = [
        'id',
        'member',
        'amount',
        'reason',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            if (! $model->amount) {
                // 奇怪的变更记录。
                return false;
            }
            // 金额大于零为收入，小于零为支出。
            $model->type = $model->amount > 0 ? static::TYPE_INCOME : static::TYPE_EXPENSE;
        });

        static::created(function ($model)
        {
            // 创建的时候，变更用户的金额。
            $model->member()->increment('cash', $model->amount);
        });

        static::updating(function ($model)
        {
            // 禁止修改记录。
            return false;
        });

        static::deleting(function ($model)
        {
            // 禁止删除记录。
            return false;
        });
    }

    /**
     * 所属会员
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }
}