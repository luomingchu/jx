<?php

/**
 * 企业信息模型
 *
 * @SWG\Model(id="Enterprise", description="企业信息模型")
 * @SWG\Property(name="id", type="integer",description="主键索引")
 * @SWG\Property(name="domain", type="string",description="企业域名")
 * @SWG\Property(name="name", type="string",description="企业名称")
 * @SWG\Property(name="Legal",type="string", description="企业法人")
 * @SWG\Property(name="logo",type="UserFile",description="企业Logo")
 * @SWG\Property(name="province",type="Province", description="所属省份")
 * @SWG\Property(name="city",type="City", description="所属城市")
 * @SWG\Property(name="district",type="District", description="所属地区")
 * @SWG\Property(name="address",type="string", description="企业地址")
 * @SWG\Property(name="longitude",type="string", description="经度")
 * @SWG\Property(name="latitude",type="string", description="纬度")
 * @SWG\Property(name="description",type="string", description="企业简介")
 * @SWG\Property(name="contracts",type="string", description="企业联系人")
 * @SWG\Property(name="phone",type="string", description="联系电话")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Enterprise extends Eloquent
{

    protected $table = 'enterprise';

    public $incrementing = true;

    protected $visible = [
        'id',
        'domain',
        'name',
        'Legal',
        'logo',
        'province',
        'city',
        'district',
        'address',
        'longitude',
        'latitude',
        'description',
        'contracts',
        'phone',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 如果logo为空，设置默认logo。
            if (isset($model->logo_id) && is_null($model->logo()->first())) {
                unset($model->logo_id);
            }
        });

        static::created(function ($model)
        {
            // 当创建一个企业后，自动创建该企业对应的企业后台帐号
            $manager = new Manager();
            $manager->enterprise_id = $model->id;
            $manager->username = $model->name;
            $manager->mobile = $model->phone;
            $manager->password = '123456';
            $manager->avatar_id = is_null($model->logo_id) ? 0 : $model->logo_id;
            $manager->real_name = $model->contacts;
            $manager->is_super = Manager::SUPER_VALID;
            $manager->save();
        });
    }

    /**
     * 旗下门店
     */
    /*
     * public function stores() { return $this->hasMany('Store'); }
     */

    /**
     * 企业旗下指店商品
     */
    public function goods()
    {
        return $this->hasMany('Goods');
    }

    /**
     * 企业旗下商品分类
     */
    public function goodsCategorys()
    {
        return $this->hasMany('GoodsCategory');
    }

    /**
     * 企业旗下总店商品
     */
    public function enterpriseGoods()
    {
        return $this->hasMany('EnterpriseGoods');
    }

    /**
     * 企业Logo
     */
    public function logo()
    {
        return $this->belongsTo('UserFile', 'logo_id');
    }

    /**
     * 所属省份
     */
    public function province()
    {
        return $this->belongsTo('Province');
    }

    /**
     * 所属城市
     */
    public function city()
    {
        return $this->belongsTo('City');
    }

    /**
     * 所属地区
     */
    public function district()
    {
        return $this->belongsTo('District');
    }

    /**
     * 门店组织
     */
    public function groups()
    {
        return $this->hasMany('Group');
    }

    /**
     * 企业地址
     */
    public function getDetailAddressAttribute()
    {
        return $this->province->name . $this->city->name . $this->district->name . $this->address;
    }

    /**
     * 用户上传的文件列表
     */
    public function files()
    {
        return $this->morphMany('UserFile', 'user');
    }

    /**
     * 企业创建的联盟
     */
    public function alliances()
    {
        return $this->hasMany('Alliance');
    }

    /**
     * 企业加入的联盟
     */
    public function joinAlliances()
    {
        return $this->hasMany('AllianceEnterprise');
    }

    /**
     * 企业拥有的任务
     */
    public function tasks()
    {
        return $this->hasMany('Task');
    }

    /**
     * 企业拥有的指店
     */
    public function vstores()
    {
        return $this->hasMany('Vstore');
    }

    /**
     * 绑定的银行卡
     */
    public function bankcard()
    {
        return $this->hasOne('EnterpriseBankcard');
    }
}