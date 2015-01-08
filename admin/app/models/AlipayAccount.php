<?php

/**
 * 支付宝关联模型
 *
 * @SWG\Model(id="AlipayAccount", description="支付宝关联模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="alipay_account", type="string",description="支付宝账号")
 * @SWG\Property(name="alipay_username", type="string",description="支付宝用户名")
 * @SWG\Property(name="is_default", type="string", enum="['Yes', 'No']", description="是否为默认地址")
 */
class AlipayAccount extends Eloquent
{

    /**
     * 是否为默认地址：是
     */
    const ISDEFAULT = 'Yes';

    /**
     * 是否为默认地址：否
     */
    const UNDEFAULT = 'No';

    protected $table = 'alipay_accounts';

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 重置其他不为默认帐号
            if ($model->is_default == Static::ISDEFAULT) {
                if ($model->id > 0) {
                    AlipayAccount::where('member_id', $model->member_id)->where('id', '<>', $model->id)->update([
                        'is_default' => AlipayAccount::UNDEFAULT
                    ]);
                } else {
                    AlipayAccount::where('member_id', $model->member_id)->update([
                        'is_default' => AlipayAccount::UNDEFAULT
                    ]);
                }
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
     * 所属退款申请
     */
    public function refunds()
    {
        return $this->morphMany('Refund', 'account');
    }

}