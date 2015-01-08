<?php
use Commands\Illuminate\Database\Eloquent\InfiniteHierarchy;

/**
 * 商品分类模型
 *
 * @SWG\Model(id="GoodsCategory", description="商品分类模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="name", type="string",description="商品分类名称")
 * @SWG\Property(name="parent_id",type="integer",description="父分类ID")
 * @SWG\Property(name="path",type="string",description="分类路径")
 * @SWG\Property(name="sort", type="integer", description="分类排序")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class GoodsCategory extends Eloquent
{
    use InfiniteHierarchy;



    protected $table = 'goods_category';

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
     * 旗下总店商品
     */
    public function goods()
    {
        return $this->belongsToMany('Goods', 'category_goods', 'goods_category_id', 'goods_id')->withTimestamps();
    }

    /**
     * 所属企业
     */
    public function enterprise()
    {
        return $this->belongsTo('Enterprise');
    }

    /**
     * 所属企业
     */
    public function scopeE($query)
    {
        return $query->where('enterprise_id', enterprise_info()->id);
    }
}