<?php

/**
 * 城市模型
 *
 * @SWG\Model(id="City", description="城市模型")
 * @SWG\Property(name="id", type="integer", description="城市ID")
 * @SWG\Property(name="name", type="string", description="城市名")
 * @SWG\Property(name="sort", type="integer", description="排序")
 * @SWG\Property(name="remark", type="string", description="备注")
 */
class City extends Eloquent
{

    protected $table = 'city';

    public $timestamps = false;

    protected $visible = [
        'id',
        'name',
        'sort',
        'remark',
        'province'
    ];

    /**
     * 城市所属的省份
     */
    public function province()
    {
        return $this->belongsTo('Province');
    }
}