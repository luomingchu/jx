<?php

/**
 * 银行卡模型
 *
 * @SWG\Model(id="Bankcard", description="银行卡模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="member", type="Member",description="所属用户")
 * @SWG\Property(name="bank", type="Bank",description="所属银行")
 * @SWG\Property(name="number", type="string",description="银行卡号")
 * @SWG\Property(name="mobile", type="string",description="预留手机号")
 * @SWG\Property(name="real_name", type="string",description="真实姓名")
 * @SWG\Property(name="open_account_bank",type="string",description="开户行名称")
 * @SWG\Property(name="is_default",type="string", enum="['Yes', 'No']", description="是否默认")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class BankCard extends Eloquent
{
    // 是否默认：是
    const ISDEFAULT = 'Yes';
    // 是否默认：否
    const UNDEFAULT = 'No';

    protected $table = 'bankcards';

    protected $visible = [
        'id',
        'member',
        'bank',
        'number',
        'mobile',
        'real_name',
        'open_account_bank',
        'is_default',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 重置其他银行卡不为默认地址
            if ($model->is_default == Static::ISDEFAULT) {
                Bankcard::where('member_id', $model->member_id)->update([
                    'is_default' => Bankcard::UNDEFAULT
                ]);
            }
        });
    }

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属银行
     */
    public function bank()
    {
        return $this->belongsTo('Bank');
    }
}