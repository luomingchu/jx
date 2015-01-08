<?php

/**
 * 指店操作记录模型
 *
 * @SWG\Model(id="VstoreLog", description="指店操作记录模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="vstore", type="Vstore",description="所属指店")
 * @SWG\Property(name="user", type="morph",description="操作者")
 * @SWG\Property(name="content", type="string",description="记录内容")
 * @SWG\Property(name="original_status",type="string", enum="['Init','Close', 'Open', 'EnterpriseAuditing', 'EnterpriseAuditError', 'EnterpriseAudited']", description="上次状态[Init-尚未开店,Open-开启，Close-关闭，EnterpriseAuditing-企业审核中，EnterpriseAuditError-企业审核未通过，EnterpriseAudited-企业审核通过]")
 * @SWG\Property(name="current_status",type="string", enum="['Close', 'Open', 'EnterpriseAuditing', 'EnterpriseAuditError', 'EnterpriseAudited']", description="当前状态[Open-开启，Close-关闭，EnterpriseAuditing-企业审核中，EnterpriseAuditError-企业审核未通过，EnterpriseAudited-企业审核通过]")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class VstoreLog extends Eloquent
{

    protected $table = 'vstore_logs';

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model)
        {
            // 禁止删除
            return false;
        });
    }

    /**
     * 所属指店
     */
    public function vstore()
    {
        return $this->belongsTo('Vstore');
    }

    /**
     * 操作人[买家or企业]
     */
    public function user()
    {
        return $this->morphTo();
    }
}