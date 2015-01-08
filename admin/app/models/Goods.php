<?php

/**
 * 总店商品模型
 *
 * @SWG\Model(id="Goods", description="商品模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="number", type="string",description="商品型号")
 * @SWG\Property(name="name", type="string",description="商品名称")
 * @SWG\Property(name="stock",type="integer",description="库存数量")
 * @SWG\Property(name="stocks",type="array",items="$ref:GoodsSku",description="商品规格库存SKU")
 * @SWG\Property(name="market_price",type="decimal", description="市场价")
 * @SWG\Property(name="price",type="decimal",description="门市价")
 * @SWG\Property(name="status",type="string", enum="['Open', 'Close']", description="商品状态")
 * @SWG\Property(name="trade_quantity", type="integer", description="已交易数量")
 * @SWG\Property(name="comment_count",type="integer",description="评论数")
 * @SWG\Property(name="favorite_count",type="integer",description="收藏数")
 * @SWG\Property(name="pictures",type="array",items="$ref:UserFile",description="商品图片")
 * @SWG\Property(name="goods_attributes",type="array",items="$ref:GoodsAttribute",description="商品销售属性")
 * @SWG\Property(name="goods_type_attributes",type="string",description="商品类别销售属性字符串")
 * @SWG\Property(name="favorited",type="string",enum="['true', 'false']",description="是否已收藏")
 * @SWG\Property(name="activity",type="ActivitiesGoods",description="活动")
 * @SWG\Property(name="brokerage_ratio",type="float",description="佣金比率")
 * @SWG\Property(name="thumbnail_url",type="string",description="缩略图url")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Goods extends Eloquent
{
    use SoftDeletingTrait;

    // 商品状态：上架
    const STATUS_OPEN = 'Open';
    // 商品状态：下架
    const STATUS_CLOSE = 'Close';

    public static $skuAttributes = null;

    protected $table = 'goods';

    protected $favoriteds = [];

    protected $activities = [];

    protected $thumbnails = [];

    protected $visible = [
        'id',
        'number',
        'name',
        'stock',
        'stocks',
        'market_price',
        'price',
        'status',
        'pictures',
        'goodsAttributes',
        'goods_attributes',
        'trade_quantity',
        'comment_count',
        'favorite_count',
        'favorited',
        //'activity',
        'thumbnail_url',
        'goods_type_attributes',
        'brokerage_ratio',
        'created_at'
    ];

    protected $with = [
        'pictures',
        'sku'
    ];

    protected $appends = [
        'favorited',
        'activity',
        'goods_type_attributes',
        'thumbnail_url'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function($model)
        {
            $model->enterprise_id = enterprise_info()->id;
        });

        static::saved(function ($model)
        {
            if (! is_null(static::$skuAttributes)) {
                if (empty(static::$skuAttributes)) {
                    // 删除原来的商品属性
                    GoodsAttribute::where('goods_id', $model->id)->delete();
                } else {
                    // 添加新的属性
                    $list = [];
                    foreach (static::$skuAttributes as $attr) {
                        foreach ($attr as $k=>$v) {
                            if (! array_key_exists($k, $list) || ! in_array($v, $list[$k])) {
                                $list[$k][] = $v;
                            }
                        }
                    }
                    $ids = [];
                    foreach ($list as $k=>$attr) {
                        foreach ($attr as $a) {
                            // 查看是否已经存在
                            $ega = GoodsAttribute::where('goods_id', $model->id)->where('goods_type_attribute_id', $k)->where('name', $a)->first();
                            if (empty($ega)) {
                                $ega = new GoodsAttribute();
                                $ega->goods_id = $model->id;
                                $ega->goods_type_attribute_id = $k;
                                $ega->name = $a;
                                $ega->save();
                            }
                            $ids[] = $ega->id;
                        }
                    }
                    // 删除已删除的销售属性
                    GoodsAttribute::where('goods_id', $model->id)->whereNotIn('id', $ids)->delete();
                }
            }
        });
    }

    // relationships

    /**
     * 所属企业
     */
    public function enterprise()
    {
        return $this->belongsTo('Enterprise');
    }


    /**
     * 所属商品类别
     */
    public function type()
    {
        return $this->belongsTo('GoodsType');
    }

    /**
     * 所属分类[一个商品多个分类，一个分类多个商品]
     */
    public function categorys()
    {
        return $this->belongsToMany('GoodsCategory', 'category_goods', 'goods_id', 'goods_category_id')->withTimestamps();
    }

    /**
     * 商品图片
     */
    public function pictures()
    {
        return $this->belongsToMany('UserFile', 'goods_pictures', 'goods_id', 'picture_id')->withTimestamps();
    }


    /**
     * 商品库存
     */
    public function sku()
    {
        return $this->hasMany('GoodsSku')->orderBy('price', 'asc');
    }

    /**
     * 被收藏的列表
     */
    public function favorites()
    {
        return $this->morphMany('Favorite', 'favorites');
    }


    /**
     * 分享列表
     */
    public function shares()
    {
        return $this->morphMany('Share', 'item');
    }

    /**
     * 商品评价列表
     */
    public function comments()
    {
        return $this->hasMany('GoodsComment');
    }

    /**
     * 商品拥有的销售属性
     */
    public function goodsAttributes()
    {
        return $this->hasMany('GoodsAttribute');
    }

    // Attributes

    /**
     * 商品活动属性
     */
    public function getActivityAttribute()
    {
        if (! isset($this->activities[$this->attributes['id']])) {
            $now_time = date('Y-m-d H:i:s');
            $store_activity = ActivitiesGoods::with('activity')->whereHas('activity', function ($q) use($now_time)
            {
                $q->where('start_datetime', '<', $now_time)
                    ->where('end_datetime', '>', $now_time)
                    ->whereStatus(Activity::STATUS_OPEN);
            })
                ->whereGoodsId($this->attributes['id'])
                ->first();
            $info = [];
            if (! empty($store_activity)) {
                $info['id'] = $store_activity->id;
                $info['discount'] = $store_activity->discount;
                $info['discount_price'] = $store_activity->discount_price;
                $info['quota'] = $store_activity->quota;
                $info['coin_max_use_ratio'] = $store_activity->coin_max_use_ratio;
                $info['deposit'] = $store_activity->deposit;
                $info['inner_purchase_ratio'] = Configs::whereKey('ratio_of_inner_purchase')->pluck('keyvalue');
                $info['brokerage_ratio'] = $store_activity->brokerage_ratio;
                $info['activity'] = $store_activity->activity;
            }
            $this->activities[$this->attributes['id']] = $info;
        }

        if (empty($this->activities[$this->attributes['id']])) {
            return null;
        }

        return $this->activities[$this->attributes['id']];
    }

    /**
     * 对价格是有小数点的进行保留两位数
     *
     * @return string
     */
    public function getPriceAttribute()
    {
        if (strpos($this->attributes['price'], '.')) {
            return sprintf('%.2f', $this->attributes['price']);
        } else {
            return $this->attributes['price'];
        }
    }

    /**
     * 当前用户是否已收藏
     */
    public function getFavoritedAttribute()
    {
        if (Auth::guest()) {
            return false;
        }
        if (! isset($this->favoriteds[$this->attributes['id']])) {
            $this->favoriteds[$this->attributes['id']] = ! is_null($this->favorites()
                ->where('member_id', Auth::user()->id)
                ->first());
        }
        return $this->favoriteds[$this->attributes['id']];
    }

    /**
     * 找出商品第一张图片作为缩略图
     */
    public function getThumbnailUrlAttribute()
    {
        if (! isset($this->thumbnails[$this->attributes['id']])) {
            if (! is_null($this->pictures()->first())) {
                $this->thumbnails[$this->attributes['id']] = $this->pictures()->first()->url;
            } else {
                $this->thumbnails[$this->attributes['id']] = '';
            }
        }
        return $this->thumbnails[$this->attributes['id']];
    }

    /**
     * 获取此商品类别的销售属性字符串
     */
    public function getGoodsTypeAttributesAttribute()
    {
        $attribute = GoodsTypeAttribute::where('goods_type_id', $this->attributes['goods_type_id'])->orderBy('sort_order', 'asc')->lists('name');
        return implode('', $attribute);
    }


    /**
     * 保存商品属性
     */
    public function setGoodsAttributesAttribute($sku_attr)
    {
        static::$skuAttributes = $sku_attr;
    }


    /**
     * 所属企业
     */
    public function scopeE($query)
    {
        return $query->where('enterprise_id', enterprise_info()->id);
    }

}