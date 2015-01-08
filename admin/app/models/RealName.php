<?php

/**
 * 实名信息模型
 *
 * @SWG\Model(id="RealName",description="实名信息模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="member",type="Member",description="所属会员")
 * @SWG\Property(name="name",type="string",description="真实姓名")
 * @SWG\Property(name="id_number",type="string",description="身份证号")
 * @SWG\Property(name="pictures",type="UserFile",description="认证图片")
 * @SWG\Property(name="status",type="string",enum="['Pending','Approved','Unapproved']",description="审核状态")
 * @SWG\Property(name="remark",type="string",description="备注信息")
 */
class RealName extends Eloquent
{

    protected $table = 'real_names';

    protected $visible = [
        'member',
        'name',
        'id_number',
        'pictures',
        'status',
        'remark'
    ];

    /**
     * 认证的用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 认证图片
     */
    public function pictures()
    {
        return $this->belongsToMany('Storage', 'real_names_pictures', 'real_name_id', 'storage_hash')->withTimestamps();
    }
}
