<?php

/**
 * 实名认证模型
 *
 * @SWG\Model(id="RealNamePicture",description="实名认证图片模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="realName",type="RealName",description="所属实名信息")
 * @SWG\Property(name="storage_hash",type="string",description="图片哈希值")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class RealNamePicture extends Eloquent
{

    protected $table = 'real_names_pictures';

    protected $visible = [
        'realName',
        'storage_hash',
        'created_at'
    ];

    /**
     * 认证的用户
     */
    public function realName()
    {
        return $this->belongsTo('RealName');
    }

    /**
     * 认证图片
     */
    public function picture()
    {
        return $this->belongsTo('Storage');
    }
}
