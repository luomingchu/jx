<?php
use Commands\Illuminate\Database\Eloquent\InfiniteHierarchy;

/**
 * 企业组织模型
 *
 * @SWG\Model(id="Group", description="企业组织模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="name", type="string",description="组织名称")
 * @SWG\Property(name="parent_id",type="integer",description="上级ID")
 * @SWG\Property(name="path",type="string",description="分类路径")
 * @SWG\Property(name="sort", type="integer", description="分类排序")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Group extends Eloquent
{
    use InfiniteHierarchy;



    protected $table = 'groups';

    protected $visible = [
        'id',
        'name',
        'parent_id',
        'path',
        'sort',
        'created_at'
    ];

    protected $appends = [
        'parent_id',
        'path'
    ];

    /**
     * 组织旗下门店（单层）
     */
    public function stores()
    {
        return $this->hasMany('Store');
    }


    /**
     * 子组织
     *
     * @param boolean $self
     *            是否包含自己，默认包含。
     */
    public function scopeAllSubGroups($query, $self = true)
    {
       return $query->where(function ($query) use($self)
        {
            $query->where('parent_path', 'like', '%:' . $this->attributes['id'] .':%');
            if ($self) {
                $query->orWhere($this->getKeyName(), $this->attributes[$this->getKeyName()]);
            }
        });
    }


    /**
     * 所管辖区域
     */
    public function storeManageArea()
    {
        return $this->morphMany('StoreManageArea', 'item');
    }
}