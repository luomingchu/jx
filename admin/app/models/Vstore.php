<?php

/**
 * 指店模型
 *
 * @SWG\Model(id="Vstore", description="指店模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="member", type="Member",description="所属用户")
 * @SWG\Property(name="enterprise", type="Enterprise",description="所属企业")
 * @SWG\Property(name="name", type="string",description="指店名称")
 * @SWG\Property(name="level", type="string",description="指店等级")
 * @SWG\Property(name="status",type="string", enum="['Close', 'Open', 'EnterpriseAuditing', 'EnterpriseAuditError', 'EnterpriseAudited','MemberGeted']", description="指店状态[Open-开启，Close-关闭,EnterpriseAuditing-企业审核中,EnterpriseAuditError-企业审核未通过,EnterpriseAudited-企业审核通过,MemberGeted-已领取并等待填写店铺名称等]")
 * @SWG\Property(name="score", type="float", description="指店评分")
 * @SWG\Property(name="enterprise_close_time",type="date-format",description="企业关闭指店时间")
 * @SWG\Property(name="enterprise_close_reason",type="string",description="企业关闭指店理由")
 * @SWG\Property(name="enterprise_audit_time",type="date-format",description="开店时企业审核时间")
 * @SWG\Property(name="enterprise_reject_reason",type="string", description="开店时企业审核不通过理由")
 * @SWG\Property(name="trade_quantity",type="integer", description="总成交商品数")
 * @SWG\Property(name="trade_amount",type="decimal", description="总成交总额")
 * @SWG\Property(name="trade_order",type="integer", description="总成交订单数")
 * @SWG\Property(name="favorited",type="string",enum="['true', 'false']",description="是否已收藏")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Vstore extends Eloquent
{

    // 指店状态：尚未开通，用于指店记录，开店的第一笔记录
    const STATUS_INIT = 'Init';

    // 指店状态：申请开店时企业审核中
    const STATUS_ENTERPRISE_AUDITING = 'EnterpriseAuditing';

    // 指店状态：申请开店时企业审核审核不通过
    const STATUS_ENTERPRISE_AUDITERROR = 'EnterpriseAuditError';

    // 指店状态：企业审核通过，即待领取指店状态
    const STATUS_ENTERPRISE_AUDITED = 'EnterpriseAudited';

    // 指店状态：用户领取成功，等待填写指店名称、图片及银行卡
    const STATUS_MEMBER_GETED = 'MemberGeted';

    // 指店状态：开启
    const STATUS_OPEN = 'Open';

    // 指店状态：关闭
    const STATUS_CLOSE = 'Close';

    protected $table = 'vstores';

    protected $favoriteds = [];

    protected $visible = [
        'id',
        'member',
        'enterprise',
        'level',
        'name',
        'status',
        'score',
        'enterprise_audit_time',
        'enterprise_reject_reason',
        'enterprise_close_time',
        'enterprise_close_reason',
        'trade_quantity',
        'trade_amount',
        'trade_order',
        'favorited',
        'created_at'
    ];

    protected $appends = [
        'favorited'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model)
        {
            // 生成指店创建记录。
            if ($model->status == Vstore::STATUS_ENTERPRISE_AUDITING) {
                // 去除填充中随意填充的状态
                $vstore_log = new VstoreLog();
                $vstore_log->vstore()->associate($model);
                $vstore_log->user()->associate($model->member);
                $vstore_log->content = sprintf('%s 创建开店申请', $model->member->real_name);
                $vstore_log->original_status = Vstore::STATUS_INIT;
                $vstore_log->current_status = $model->status;
                $vstore_log->save();
            }
        });

        static::updated(function ($model)
        {
            if ($model->isDirty('status') && $model->status == static::OPEN_ENTERPRISE_AUDITED) {
                $vstore_log = new VstoreLog();
                $vstore_log->vstore()->associate($model);
                $vstore_log->user()->associate(Auth::user());
                switch ($model->status) {
                    case static::STATUS_OPEN:
                        $vstore_log->content = '开店成功';
                        break;
                    case static::STATUS_CLOSE:
                        $vstore_log->content = '企业关闭店铺，关闭理由：' . $model->enterprise_close_reason;
                        break;
                    case static::STATUS_ENTERPRISE_AUDITING:
                        $vstore_log->content = $model->member->real_name . ' 创建开店申请';
                        break;
                    case static::STATUS_ENTERPRISE_AUDITERROR:
                        $vstore_log->content = '企业拒绝用户的开店申请，拒绝理由：' . $model->enterprise_reject_reason;
                        break;
                    case static::STATUS_ENTERPRISE_AUDITED:
                        $vstore_log->content = '企业审核通过' . $model->member->real_name . '的开店申请，等待用户领取';
                        break;
                    case static::STATUS_MEMBER_GETED:
                        $vstore_log->content = $model->member->real_name . '领取店铺成功，等待填写店铺名称、Logo及绑定银行卡';
                        break;
                }
                $vstore_log->original_status = $model->getOriginal('status');
                $vstore_log->current_status = $model->status;
                $vstore_log->save();
            }
        });
    }

    /**
     * 所属用户
     */
    public function member()
    {
        return $this->belongsTo('Member');
    }

    /**
     * 所属企业
     */
    public function enterprise()
    {
        return $this->belongsTo('Enterprise');
    }

    /**
     * 被收藏的指店
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
     * 指店佣金列表
     */
    public function brokerage()
    {
        return $this->hasMany('Brokerage');
    }

    /**
     * 指店所属等级信息
     */
    public function vstoreLevel()
    {
        return $this->belongsTo('VstoreLevel', 'level', 'level');
    }

    /**
     * 属于指店的订单
     */
    public function orders()
    {
        return $this->hasMany('Order');
    }

    /**
     * 当前用户是否已收藏
     */
    public function getFavoritedAttribute()
    {
        if (Auth::guest()) {
            return false;
        }
        if (! isset($this->favoriteds[$this->id])) {
            $this->favoriteds[$this->id] = ! is_null($this->favorites()
                ->where('member_id', Auth::user()->id)
                ->first());
        }
        return $this->favoriteds[$this->id];
    }
}