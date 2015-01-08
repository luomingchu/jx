<?php

/**
 * 存储的文件
 *
 * @SWG\Model(id="Storage",description="文件")
 * @SWG\Property(name="hash",type="string", description="文件hash")
 * @SWG\Property(name="size",type="integer", description="字节大小")
 * @SWG\Property(name="width",type="integer", description="宽度")
 * @SWG\Property(name="height",type="integer", description="高度")
 * @SWG\Property(name="mime",type="string", description="Mime")
 * @SWG\Property(name="seconds",type="double", description="时长（秒）")
 * @SWG\Property(name="format",type="string", description="文件格式")
 */
class Storage extends Eloquent
{

    protected $table = 'storage';

    protected $primaryKey = 'hash';

    public $incrementing = false;

    protected $visible = [
        'hash',
        'size',
        'width',
        'height',
        'mime',
        'seconds',
        'format'
    ];
}
