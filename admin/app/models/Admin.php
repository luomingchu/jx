<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * 管理员
 *
 * @SWG\Model(id="Admin",description="管理员")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="username",type="string",description="用户名")
 * @SWG\Property(name="mobile",type="string",description="手机号")
 * @SWG\Property(name="email",type="string",description="邮箱")
 * @SWG\Property(name="created_at",type="date-format",description="注册时间")
 */
class Admin extends Eloquent implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected $table = 'admins';

    protected $visible = [
        'id',
        'username',
        'mobile',
        'email',
        'created_at'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model)
        {
            // 保存的时候自动对密码进行加密。
            if (isset($model->password) && Hash::needsRehash($model->password)) {
                $model->password = Hash::make($model->password);
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
     * 用户上传的文件列表
     */
    public function files()
    {
        return $this->morphMany('UserFile', 'user');
    }

    /**
     * email 转为string类型
     *
     */
    public function getEmailAttribute()
    {
        return (string) $this->attributes['email'];
    }
}
