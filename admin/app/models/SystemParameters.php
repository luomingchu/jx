<?php

/**
 * 系统参数模型
 *
 * @SWG\Model(id="SystemParameters", description="系统参数模型")
 * @SWG\Property(name="key", type="string",description="键")
 * @SWG\Property(name="value", type="string",description="值")
 */
class SystemParameters extends Eloquent
{



    protected $table = 'system_parameters';

    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $visible = [
        'key',
        'keyvalue',
        'remark'
    ];

    public $timestamps = false;

    //是否显示： 是
    const IS_SHOW_YES = "Yes";

    //是否显示： 否
    const IS_SHOW_NO = "No";
}