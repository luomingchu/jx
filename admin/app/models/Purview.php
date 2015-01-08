<?php
use Commands\Illuminate\Database\Eloquent\InfiniteHierarchy;
/**
 * 权限模型
 */
class Purview extends Eloquent
{

    use InfiniteHierarchy;

    /**
     * 状态：开启
     */
    const STATUS_VALID = 'Valid';

    /**
     * 状态：关闭
     */
    const STATUS_INVALID = 'Invalid';

    /**
     * 类型：菜单
     */
    const TYPE_MENU = 'Menu';

    /**
     * 类型：普通操作
     */
    const TYPE_ACTION = 'Action';

    protected $table = 'purviews';

    public $timestamps = false;

    protected $appends = [
        'path',
        'parent_id'
    ];


    /**
     * 属于哪些角色
     */
    public function roles()
    {
        return $this->belongsToMany('Role', 'role_purview', 'purview_id', 'role_id');
    }


    /**
     * 生成路径附加条件
     */
    public function getConditionAttribute()
    {
        if (! empty($this->attributes['condition'])) {
            parse_str($this->attributes['condition'], $query);
            return count(array_filter($query)) > 0 ? $query : [$this->attributes['condition']];
        }
        return [];
    }

}