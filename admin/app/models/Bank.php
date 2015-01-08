<?php

/**
 * 银行模型
 *
 * @SWG\Model(id="Bank", description="银行模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="name", type="string",description="银行名称")
 * @SWG\Property(name="logo_hash", type="string",description="银行Logo")
 * @SWG\Property(name="logo_url", type="string",description="银行Logo地址")
 * @SWG\Property(name="hotline", type="string",description="银行热线电话")
 * @SWG\Property(name="remark", type="string",description="银行简介")
 * @SWG\Property(name="sort", type="integer",description="排序值(大排前)")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Bank extends Eloquent
{

    protected $table = 'banks';

    protected $visible = [
        'id',
        'name',
        'logo_hash',
        'logo_url',
        'hotline',
        'remark',
        'sort',
        'created_at'
    ];

    protected $appends = [
        'logo_url'
    ];

    /**
     * 银行Logo
     */
    public function logo()
    {
        return $this->belongsTo('Storage', 'logo_hash');
    }

    /**
     * 文件CDN地址
     */
    public function getLogoUrlAttribute()
    {
        return action('StorageController@getFile', [
            'hash' => $this->logo_hash
        ]);
    }
}