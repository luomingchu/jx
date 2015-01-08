<?php
/**
 * 商品销售属性表
 *
 * @SWG\Model(id="GoodsAttribute", description="商品销售属性表")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="name", type="string",description="属性值")
 * @SWG\Property(name="attribute_name", type="string",description="属性名")
 * @SWG\Property(name="attribute_index", type="integer",description="属性排序号")
 */
class GoodsAttribute extends Eloquent
{



    protected $table = 'goods_attributes';

    protected $fillable = [
        'goods_id',
        'goods_type_attribute_id',
        'name'
    ];

    protected $visible = [
        'id',
        'name',
        'attribute_name',
        'attribute_index'
    ];

    protected $appends = [
        'attribute_name',
        'attribute_index'
    ];

    public $timestamps = false;

    /**
     * 所属商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }

    /**
     * 所属商品类型属性
     */
    public function goodsTypeAttribute()
    {
        return $this->belongsTo('GoodsTypeAttribute');
    }

    /**
     * 获取商品类别属性名
     */
    public function getAttributeNameAttribute()
    {
        static $attribute = [];
        if (! array_key_exists($this->attributes['goods_type_attribute_id'], $attribute)) {
            $attribute[$this->attributes['goods_type_attribute_id']] = GoodsTypeAttribute::where('id', $this->attributes['goods_type_attribute_id'])->pluck('name');
        }
        return $attribute[$this->attributes['goods_type_attribute_id']];
    }


    /**
     * 获取商品类别属性名
     */
    public function getAttributeIndexAttribute()
    {
        static $attribute = [];
        if (! array_key_exists($this->attributes['goods_type_attribute_id'], $attribute)) {
            $attribute[$this->attributes['goods_type_attribute_id']] = GoodsTypeAttribute::where('id', $this->attributes['goods_type_attribute_id'])->pluck('sort_order');
        }
        return $attribute[$this->attributes['goods_type_attribute_id']];
    }


}