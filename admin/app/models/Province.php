<?php

/**
 * 省份模型
 *
 * @SWG\Model(id="Province",description="省份模型")
 * @SWG\Property(name="id",type="integer",description="主键索引")
 * @SWG\Property(name="name",type="string",description="省份名")
 * @SWG\Property(name="sort",type="integer",description="排序")
 * @SWG\Property(name="remark",type="string",description="备注")
 */
class Province extends Eloquent
{

    protected $table = 'province';

    public $timestamps = false;

    protected $visible = [
        'id',
        'name',
        'sort',
        'remark',
        'city'
    ];

    /**
     * 省份下的城市列表
     */
    public function city()
    {
        return $this->hasMany('City');
    }
}