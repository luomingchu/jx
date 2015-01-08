<?php

/**
 * 系统参数模型
 *
 * @SWG\Model(id="EnterpriseSystemParameters", description="系统参数模型")
 * @SWG\Property(name="key", type="string",description="键")
 * @SWG\Property(name="value", type="string",description="值")
 */
class EnterpriseSystemParameters extends Eloquent
{

    protected $table = 'enterprise_system_parameters';

    public $incrementing = false;

    protected $visible = [
        'key',
        'keyvalue',
        'remark'
    ];

    public $timestamps = false;



}