<?php

/**
 * 员工模型
 *
 * @SWG\Model(id="Staff",description="员工模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="real_name",type="string",description="真实姓名")
 * @SWG\Property(name="mobile",type="string",description="手机号")
 * @SWG\Property(name="staff_no",type="string",description="工号")
 * @SWG\Property(name="gender",type="string",description="性别",enum="{'Man':'男','Female':'女'}")
 * @SWG\Property(name="age",type="integer",description="年龄")
 * @SWG\Property(name="member_id",type="integer",description="对应用户id")
 * @SWG\Property(name="store_id",type="integer",description="所在门店id")
 * @SWG\Property(name="status",type="string",description="性别",enum="{'Valid':'在职','Invalid':'离职'}")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Staff extends Eloquent
{

    // 状态：在职
    const STATUS_VALID = 'Valid';
    // 状态：离职
    const STATUS_INVALID = 'Invalid';



    protected $table = 'staffs';

    protected $visible = [
        'id',
        'member',
        'gender',
        'real_name',
        'age',
        'store',
        'staff_no',
        'status',
        'mobile',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();
    }

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属门店
     */
    public function store()
    {
        return $this->belongsTo('Store');
    }


}
