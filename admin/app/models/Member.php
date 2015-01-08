<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * 会员模型
 *
 * @SWG\Model(id="Member",description="会员模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="mobile",type="string",description="手机号")
 * @SWG\Property(name="nickname",type="string",description="昵称")
 * @SWG\Property(name="email",type="string",description="邮箱")
 * @SWG\Property(name="id_number",type="string",description="身份证号")
 * @SWG\Property(name="id_picture",type="UserFile",description="持证照")
 * @SWG\Property(name="info",type="MemberInfo",description="用户信息")
 * @SWG\Property(name="vstore",type="Vstore",description="我的指店")
 * @SWG\Property(name="avatar",type="UserFile",description="头像")
 * @SWG\Property(name="gender",type="string",description="性别",enum="{'Man':'男','Female':'女'}")
 * @SWG\Property(name="real_name",type="string",description="真实姓名")
 * @SWG\Property(name="birthday",type="date-format",description="生日")
 * @SWG\Property(name="signature",type="string",description="用户个性签名")
 * @SWG\Property(name="region_name",type="string",description="用户所在地")
 * @SWG\Property(name="province",type="Province",description="所在省份")
 * @SWG\Property(name="city",type="City",description="所在城市")
 * @SWG\Property(name="district",type="District",description="所在地区")
 * @SWG\Property(name="created_at",type="date-format",description="注册时间")
 */
class Member extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    // 性别：男
    const GENDER_MAN = 'Man';
    // 性别：女
    const GENDER_FEMALE = 'Female';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    protected $visible = [
        'id',
        'mobile',
        'nickname',
        'email',
        'id_number',
        'id_picture',
        'info',
        'vstore',
        'avatar',
        'gender',
        'real_name',
        'birthday',
        'region_name',
        'province',
        'city',
        'district',
        'signature',
        'created_at'
    ];

    protected $with = [
        'avatar',
        'id_picture',
        'province',
        'city',
        'district',
        'info',
        'vstore'
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array(
        'password',
        'remember_token'
    );

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 保存的时候自动对密码进行加密。
            if (isset($model->password) && Hash::needsRehash($model->password)) {
                $model->password = Hash::make($model->password);
            }

            // 禁止对账户金额进行修改。
            if ($model->isDirty('cash')) {
                return false;
            }
        });
    }

    /**
     * 头像
     */
    public function avatar()
    {
        return $this->belongsTo('UserFile', 'avatar_id');
    }

    /**
     * 持证照
     */
    public function id_picture()
    {
        return $this->belongsTo('UserFile', 'id_picture_id');
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
     * 用户上传的文件列表
     */
    public function files()
    {
        return $this->morphMany('UserFile', 'user');
    }

    /**
     * 发布的问题列表
     */
    public function questions()
    {
        return $this->morphMany('Question', 'user');
    }

    /**
     * 拥有的退款退货记录
     */
    public function refundLogs()
    {
        return $this->morphMany('RefundLog', 'user');
    }

    /**
     * 指店操作记录
     */
    public function vstoreLogs()
    {
        return $this->morphMany('VstoreLog', 'user');
    }

    /**
     * 发布的回答列表
     */
    public function answers()
    {
        return $this->hasMany('Answer');
    }

    /**
     * 对系统软件提出的意见
     */
    public function suggestions()
    {
        return $this->hasMany('Suggestion');
    }

    /**
     * 对商品提出的意见
     */
    public function suggests()
    {
        return $this->hasMany('Suggest');
    }

    /**
     * 用户关注列表
     */
    public function attentions()
    {
        return $this->hasMany('Attention');
    }

    /**
     * 用户的信息
     */
    public function info()
    {
        return $this->hasOne('MemberInfo');
    }

    /**
     * 用户的指店
     */
    public function vstore()
    {
        return $this->hasOne('Vstore');
    }

    /**
     * 用户的好友
     */
    public function friends()
    {
        return $this->hasMany('Attention');
    }

    /**
     * 用户的订单
     */
    public function orders()
    {
        return $this->hasMany('Order');
    }

    /**
     * 购物车商品数
     */
    public function cart()
    {
        return $this->hasMany('Cart');
    }

    /**
     * 收发货地址
     */
    public function address()
    {
        return $this->hasMany('Address');
    }

    /**
     * 用户消息列表
     */
    public function messages()
    {
        return $this->morphMany('Message', 'member');
    }

    /**
     * 银行卡
     */
    public function bankcards()
    {
        return $this->hasMany('Bankcard');
    }

    /**
     * 员工信息
     */
    public function staff()
    {
        return $this->hasOne('Staff');
    }

    /**
     * 绑定的支付宝
     */
    public function alipayAccounts()
    {
        return $this->hasMany('AlipayAccount');
    }

    /**
     * 获取用户和当前用户的关注关系
     */
    public function getRelationshipAttribute()
    {
        $relationship = 'Unattention';
        if (Auth::check()) {
            $owner = Auth::user()->id;
            if ($this->attributes['id'] == $owner) {
                $relationship = 'Own';
            } else {
                $attention = Attention::where('member_id', $owner)->where('friend_id', $this->attributes['id'])->first();
                if (! empty($attention)) {
                    $relationship = $attention->relationship;
                }
            }
        }
        return $relationship;
    }

    /**
     * email 转为string类型
     */
    public function getEmailAttribute()
    {
        return (string) $this->attributes['email'];
    }

    /**
     * nickname 转为string类型
     */
    public function getNicknameAttribute()
    {
        return (string) $this->attributes['nickname'];
    }

    /**
     * birthday 转为string类型
     */
    public function getBirthdayAttribute()
    {
        return (string) $this->attributes['birthday'];
    }

}
