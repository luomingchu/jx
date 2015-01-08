<?php

/**
 * 企业设置模型
 *
 * @SWG\Model(id="EnterpriseConfig", description="企业设置模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="enterprise", type="Enterprise",description="所属企业")
 * @SWG\Property(name="admin_logo_hash", type="string",description="后台站头logo")
 * @SWG\Property(name="admin_logo_hash2", type="string",description="下载页面的logo")
 * @SWG\Property(name="login_logo_hash", type="string",description="登录页面logo")
 * @SWG\Property(name="login_big_hash", type="string",description="登录页面右边大图")
 * @SWG\Property(name="login_color", type="string",description="登录界面颜色值")
 */
class EnterpriseConfig extends Eloquent
{

    protected $table = 'enterprise_configs';

    public $timestamps = false;

    protected $visible = [
        'id',
        'enterprise',
        'admin_logo_hash',
        'admin_logo_hash2',
        'login_logo_hash',
        'login_big_hash',
        'login_color'
    ];

    /**
     * 所属企业
     */
    public function enterprise()
    {
        return $this->belongsTo('Enterprise');
    }
}