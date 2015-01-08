<?php

/**
 * 活动模型
 *
 * @SWG\Model(id="Activity", description="活动模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="title", type="string",description="活动标题")
 * @SWG\Property(name="picture", type="UserFile",description="活动图片")
 * @SWG\Property(name="introduction", type="string",description="活动介绍")
 * @SWG\Property(name="body", type="morphs",description="活动信息")
 * @SWG\Property(name="body_type", type="string",description="活动类型")
 * @SWG\Property(name="start_datetime",type="date-format",description="开始时间")
 * @SWG\Property(name="end_datetime",type="date-format",description="结束时间")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Activity extends Eloquent
{

    use SoftDeletingTrait;

    /**
     * 活动类型：预售活动
     */
    const TYPE_PRESELL = 'Presell';

    /**
     * 活动类型：内购活动
     */
    const TYPE_INNER_PURCHASE = 'InnerPurchase';

    /**
     * 状态：开启
     */
    const STATUS_OPEN = 'Open';

    /**
     * 状态：关闭
     */
    const STATUS_CLOSE = 'Close';



    protected $table = 'activities';

    protected $visible = [
        'id',
        'title',
        'picture',
        'introduction',
        'body',
        'body_type',
        'goods',
        'start_datetime',
        'end_datetime',
        'created_at'
    ];

    protected $with = [
        'picture'
    ];

    /**
     * 参与商品列表
     */
    public function goods()
    {
        return $this->hasMany('ActivitiesGoods');
    }

    /**
     * 活动信息
     */
    public function body()
    {
        return $this->morphTo();
    }

    /**
     * 活动投放区域
     */
    public function groups()
    {
        return $this->belongsToMany('Group', 'activities_groups', 'activity_id', 'group_id');
    }

    /**
     * 活动商品
     */
    public function picture()
    {
        return $this->belongsTo('UserFile', 'picture_id');
    }

    /**
     * 门店获取列表
     */
    public function storeActivities()
    {
        return $this->hasMany('StoreActivity', 'activity_id');
    }
}