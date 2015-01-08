<?php

/**
 * 收货地址模型
 *
 * @SWG\Model(id="Address", description="收货地址模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="member", type="Member",description="所属用户")
 * @SWG\Property(name="consignee", type="string",description="收件人姓名")
 * @SWG\Property(name="mobile", type="string",description="收件人手机号")
 * @SWG\Property(name="phone", type="string",description="电话号码（固话）")
 * @SWG\Property(name="zipcode", type="string",description="收件人邮编")
 * @SWG\Property(name="province",type="Province",description="省份")
 * @SWG\Property(name="city",type="City",description="市级")
 * @SWG\Property(name="district",type="District",description="地区")
 * @SWG\Property(name="region_name",type="string", description="省市区地址")
 * @SWG\Property(name="address",type="string", description="详细地址")
 * @SWG\Property(name="is_default",type="string", enum="['Yes', 'No']", description="是否默认地址")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Address extends Eloquent
{
    // 是否默认地址：是
    const ISDEFAULT = 'Yes';
    // 是否默认地址：否
    const UNDEFAULT = 'No';

    /**
     * 地址类型：收货地址
     */
    const TYPE_RECEIPT = 'Receipt';

    /**
     * 地址类型：发货地址
     */
    const TYPE_DELIVER = 'Deliver';

    protected $table = 'address';

    protected $visible = [
        'id',
        'member',
        'consignee',
        'mobile',
        'phone',
        'zipcode',
        'province',
        'city',
        'district',
        'region_name',
        'address',
        'is_default',
        'created_at'
    ];

    protected $with = [
        'province',
        'city',
        'district'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 重置其他收货不为默认地址
            if ($model->is_default == Static::ISDEFAULT) {
                if ($model->id > 0) {
                    Address::where('member_id', $model->member_id)->where('type', $model->type)
                        ->where('id', '<>', $model->id)
                        ->update([
                        'is_default' => Address::UNDEFAULT
                    ]);
                } else {
                    Address::where('member_id', $model->member_id)->where('type', $model->type)->update([
                        'is_default' => Address::UNDEFAULT
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
     * 所属省份
     */
    public function province()
    {
        return $this->belongsTo('Province');
    }

    /**
     * 所属市级
     */
    public function city()
    {
        return $this->belongsTo('City');
    }

    /**
     * 所属地区
     */
    public function district()
    {
        return $this->belongsTo('District');
    }
}