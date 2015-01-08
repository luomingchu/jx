<?php

/**
 * 内购额明细
 *
 * @author Latrell Chan
 *
 * @SWG\Model(id="Insource")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="amount",type="float",description="变更金额")
 * @SWG\Property(name="key",type="string",description="来源&原因key")
 * @SWG\Property(name="type",type="string",enum="{'Income':'收入','Expense':'支出'}",description="类型")
 * @SWG\Property(name="source",type="Source",description="来源&原因")
 * @SWG\Property(name="remark",type="Source",description="备注")
 * @SWG\Property(name="created_at",type="date-format",description="时间")
 */
class Insource extends Eloquent
{

    /**
     * 变更类型：收入
     */
    const TYPE_INCOME = 'Income';

    /**
     * 变更类型：支出
     */
    const TYPE_EXPENSE = 'Expense';



    protected $table = 'insource';

    protected $visible = [
        'id',
        'member',
        'amount',
        'key',
        'source',
        'type',
        'remark',
        'created_at'
    ];

    protected $with = [
        'source'
    ];

    // 总额为正时是否累加到总收益中
    public static $cumulation = true;

    // 是否应用等级
    public static $apply_level = true;

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
            if ($model->amount > 0) {
                $model->type = static::TYPE_INCOME;
                // 获取用户的等级
                $member = $model->member;
                if (static::$apply_level && ! empty($member->info->level)) {
                    $levelInfo = Level::where('level', $member->info->level)->first();
                    // 根据用户等级，附加等级内购额
                    if (! empty($levelInfo)) {
                        $model->amount += $levelInfo->insource;
                    }
                }
            } else {
                $model->type = static::TYPE_EXPENSE;
            }
        });

        static::created(function ($model)
        {
            // 创建的时候，变更用户的金额。
            $model->memberInfo()->increment('insource', $model->amount);

            // 记录总收益
            if ($model->amount > 0 && static::$cumulation) {
                $model->memberInfo()->increment('insource_amount', $model->amount);
            }
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
     * 所属来源
     */
    public function source()
    {
        return $this->belongsTo('Source', 'key', 'key');
    }

    /**
     * 所属会员
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属会员信息
     */
    public function memberInfo()
    {
        return $this->belongsTo('MemberInfo', 'member_id', 'member_id');
    }
}