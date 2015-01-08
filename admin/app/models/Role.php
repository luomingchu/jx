<?php
/**
 * 角色模型
 */
class Role extends Eloquent
{

    /**
     * 状态：开启
     */
    const STATUS_VALID = 'Valid';

    /**
     * 状态：禁用
     */
    const STATUS_INVALID = 'Invalid';


    protected $table = 'roles';



    public static function boot()
    {
        parent::boot();

        static::deleted(function ($model)
        {
            // 删除成员关联数据
            $model->managers()->sync([]);

            // 删除权限关联数据
            $model->purviews()->sync([]);
        });
    }


    /**
     * 拥有的权限列表
     */
    public function purviews()
    {
        return $this->belongsToMany('Purview', 'role_purview', 'role_id', 'purview_id');
    }

    /**
     * 角色成员列表
     */
    public function managers()
    {
        return $this->belongsToMany('Manager', 'role_manager', 'role_id', 'manager_id');
    }



}