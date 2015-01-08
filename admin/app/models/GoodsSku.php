<?php
/**
 * 商品库存模型
 *
 * @SWG\Model(id="GoodsSku", description="商品库存模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="stock", type="string",description="商品库存")
 * @SWG\Property(name="price", type="string",description="商品价格")
 * @SWG\Property(name="sky_key",type="array",description="商品规格值数组")
 * @SWG\Property(name="sky_index",type="string",description="商品规格ID字符串")
 * @SWG\Property(name="sky_string",type="string",description="商品规格详细字符串")
 */
class GoodsSku extends Eloquent
{



    protected $table = 'goods_sku';

    public $timestamps = false;

    protected $visible = [
        'id',
        'sku_key',
        'sku_index',
        'sku_string',
        'stock',
        'price'
    ];

    protected $appends = [
        'sku_string'
    ];

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model)
        {
            // 修改商品总库存数
            Goods::where('id', $model->goods_id)->update(['stock' => GoodsSku::where('goods_id', $model->goods_id)->sum('stock')]);
        });

        static::deleted(function ($model)
        {
            // 修改商品总库存数
            Goods::where('id', $model->goods_id)->update(['stock' => GoodsSku::where('goods_id', $model->goods_id)->sum('stock')]);
        });
    }

    /**
     * 所属商品
     */
    public function goods()
    {
        return $this->belongsTo('Goods');
    }
    
    /**
     * 获取规格数组
     */
    public function getSkuKeyAttribute()
    {
        if (! empty($this->attributes['sku_key'])) {
            return explode(':', $this->attributes['sku_key']);
        }
        return [];
    }

    /**
     * 获取商品规格字符串
     */
    public function getSkuStringAttribute()
    {
        // 获取商品信息
        $goods_info = Goods::find($this->attributes['goods_id']);
        // 获取商品类别属性信息
        $goods_type_attribute = GoodsTypeAttribute::where('goods_type_id', $goods_info['goods_type_id'])->orderBy('sort_order', 'asc')->get();

        $sku_string = [];
        if (! empty($this->attributes['sku_key'])) {
            $sku_key = explode(':', $this->attributes['sku_key']);
            foreach ($sku_key as $skk=>$sk) {
                if ($goods_type_attribute->has($skk)) {
                    $sku_string[] = $goods_type_attribute->get($skk)->name."：{$sk}";
                }
            }
        }
        return implode('；', $sku_string);
    }
}