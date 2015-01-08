<?php

/**
 * 商品的意见建议【分库】
 *
 * @author jois
 *
 * @SWG\Model(id="Suggest",description="模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="member",type="Member",description="提意见者")
 * @SWG\Property(name="content",type="string",description="内容")
 * @SWG\Property(name="ip",type="string",description="提交者的IP")
 * @SWG\Property(name="created_at",type="date-format",description="提交时间")
 */
class Suggest extends Eloquent
{



    protected $table = 'suggest';

    protected $visible = [
        'id',
        'member',
        'content',
        'ip',
        'created_at'
    ];

    /**
     * 提意见者
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }
}