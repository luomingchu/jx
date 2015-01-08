<?php

/**
 * 广告位模型
 *
 * @SWG\Model(id="AdvertiseSpace", description="广告位模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="name", type="string",description="广告位名称")
 * @SWG\Property(name="key_code", type="string",description="广告位标识符")
 * @SWG\Property(name="remark", type="string",description="广告位备注")
 */
class AdvertiseSpace extends Eloquent
{

    /**
     * the database table used by the model
     *
     * @var string
     */
    protected $table = 'advertise_spaces';

    /**
     * 配置软件删除
     */
    use SoftDeletingTrait;

    protected $visible = [
        'id',
        'name',
        'key_code',
        'remark'
    ];

    /**
     * 广告位里的广告
     */
    public function advertises()
    {
        return $this->hasMany('Advertise', 'space_id');
    }
}