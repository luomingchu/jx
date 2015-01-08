<?php

/**
 * 地区模型
 *
 * @SWG\Model(id="District", description="地区模型")
 * @SWG\Property(name="id", type="integer", description="地区ID")
 * @SWG\Property(name="name", type="string", description="地区名")
 * @SWG\Property(name="city", type="City", description="城市名")
 */
class District extends Eloquent
{

    protected $table = 'district';

    public $timestamps = false;

    protected $visible = [
        'id',
        'name',
        'city'
    ];

    /**
     * 所属城市
     */
    public function city()
    {
        return $this->belongsTo('City');
    }
}