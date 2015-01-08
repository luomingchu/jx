<?php

/**
 * 用户文件
 *
 * @SWG\Model(id="UserFile",description="用户文件")
 * @SWG\Property(name="id",type="integer", description="主键")
 * @SWG\Property(name="user",type="morphs", description="所属者")
 * @SWG\Property(name="user_type",type="string", description="所属者类型")
 * @SWG\Property(name="storage",type="Storage", description="文件")
 * @SWG\Property(name="filename",type="integer", description="文件名")
 * @SWG\Property(name="url",type="string", description="CDN地址")
 */
class UserFile extends Eloquent
{

    protected $table = 'user_files';

    protected $visible = [
        'id',
        'user',
        'user_type',
        'storage',
        'filename',
        'url',
        'size',
        'mime'
    ];

    protected $appends = [
        'url',
        'size',
        'mime'
    ];

    protected $with = [
        // 'user',
        'storage'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
//            $model->filename = preg_replace('/\..*$/i', '', basename($model->filename));
        });
    }

    /**
     * 所属用户
     */
    public function user()
    {
        return $this->morphTo();
    }

    /**
     * 文件
     */
    public function storage()
    {
        return $this->belongsTo('Storage', 'storage_hash');
    }

    /**
     * 缩略图列表
     */
    public function thumbnails()
    {
        return $this->belongsToMany('Storage', 'thumbnails', 'file_id', 'storage_hash');
    }

    /**
     * 文件CDN地址
     */
    public function getUrlAttribute()
    {
        return action('StorageController@getFile', [
            'id' => $this->id
        ]);
    }

    /**
     * 文件大小
     */
    public function getSizeAttribute()
    {
        return Storage::find($this->storage_hash)->size;
    }

    /**
     * 文件类型
     */
    public function getMimeAttribute()
    {
        return Storage::find($this->storage_hash)->mime;
    }
}
