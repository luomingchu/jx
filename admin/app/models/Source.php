<?php

/**
 * 指币内购额来源模型
 *
 * @SWG\Model(id="Source", description="指币内购额来源模型")
 * @SWG\Property(name="key", type="string",description="主键索引")
 * @SWG\Property(name="name", type="string",description="来源名称")
 * @SWG\Property(name="remark",type="string",description="来源备注")
 */
class Source extends Eloquent
{

    protected $table = 'sources';

    protected $primaryKey = 'key';

    public $incrementing = false;

    public $timestamps = false;

    protected $visible = [
        'key',
        'name'
        //'remark'
    ];

    /**
     * 任务
     */
    public function task()
    {
        return $this->hasOne('Task', 'key', 'key');
    }
}