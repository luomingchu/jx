<?php
namespace Commands\Illuminate\Database\Eloquent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

/**
 * 目录方式的无限级分类
 */
trait InfiniteHierarchy
{

    // protected $appends = [
    // 'parent_id',
    // 'path'
    // ];
    public static function boot()
    {
        parent::boot();

        static::updating(function ($model)
        {
            // 如果修改了 parent_path 属性，同步更改所有子模型的 parent_path 。
            if ($model->isDirty('parent_path')) {
                // 防止树循环。阻止将当前分类放到子分类下。
                if (! empty($model->parent_path)) {
                    $parent_node = $model->parentNode()->first();
                    if (is_null($parent_node) || preg_match('/:' . $model->{$model->getKeyName()} . ':/', $parent_node->parent_path)) {
                        throw new \Exception('所属父级不能为空，且其新的父级不能为其原来的子级！');
                        return false;
                    }
                }
                // 为了性能，不使用递归，直接操作数据表。
                $old_path = ($model->getOriginal('parent_path') ?  : ':') . $model->{$model->getKeyName()} . ':';
                DB::update('UPDATE `' . $model->getTable() . '` SET `parent_path` = CONCAT(\'' . $model->path . '\', substring(`parent_path`, ' . (strlen($old_path) + 1) . ')) WHERE `parent_path` LIKE \'' . $old_path . '%\'');
            }
        });
    }

    /**
     * 父模型ID
     */
    public function getParentIdAttribute()
    {
        if (! isset($this->attributes['parent_path'])) {
            return null;
        }
        return (int) last(explode(':', trim($this->attributes['parent_path'], ':')));
    }

    /**
     * 设置父模型ID的时候，自动修正 parent_path 属性。
     */
    public function setParentIdAttribute($value)
    {
        $parent = $value ? static::find($value) : null;
        $this->attributes['parent_path'] = is_null($parent) ? '' : $parent->path;
    }

    /**
     * 当前模型路径
     */
    public function getPathAttribute()
    {
        return ($this->attributes['parent_path'] ?  : ':') . $this->attributes[$this->getKeyName()] . ':';
    }

    /**
     * 顶级节点列表
     */
    public function scopeTopNodes($query)
    {
        return $query->whereParentPath('');
    }

    /**
     * 父节点
     */
    public function scopeParentNode($query)
    {
        return $query->whereId($this->parent_id);
    }

    /**
     * 子节点
     */
    public function scopeChildNode($query)
    {
        return $query->whereParentPath($this->path);
    }

    /**
     * 所有子节点
     *
     * @param boolean $self
     *            是否包含自己，默认不包含。
     */
    public function scopeChildNodes($query, $self = false)
    {
        return $query->where(function ($query) use($self)
        {
            $query->where('parent_path', 'like', $this->path . '%');
            if ($self) {
                $query->orWhere($this->getKeyName(), $this->attributes[$this->getKeyName()]);
            }
        });
    }
}
