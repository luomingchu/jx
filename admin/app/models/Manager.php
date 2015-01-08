<?php
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * 企业管理员模型
 *
 * @SWG\Model(id="Manager",description="企业管理员模型")
 * @SWG\Property(name="id",type="integer",description="主键")
 * @SWG\Property(name="username",type="string",description="用户名")
 * @SWG\Property(name="real_name",type="string",description="真实姓名")
 * @SWG\Property(name="mobile",type="string",description="手机号")
 * @SWG\Property(name="email",type="string",description="邮箱")
 * @SWG\Property(name="avatar",type="UserFile",description="头像")
 * @SWG\Property(name="gender",type="string",description="性别",enum="{'Man':'男','Female':'女'}")
 * @SWG\Property(name="status",type="string",description="性别",enum="{'Valid':'在职','Invalid':'离职'}")
 * @SWG\Property(name="prev_login_time",type="date-format",description="上次登录时间")
 * @SWG\Property(name="last_login_time",type="date-format",description="最后登录时间")
 * @SWG\Property(name="created_at",type="date-format",description="创建时间")
 */
class Manager extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait, SoftDeletingTrait;

    // 性别：男
    const GENDER_MAN = 'Man';
    // 性别：女
    const GENDER_FEMALE = 'Female';

    // 状态：开启
    const STATUS_INVALID = 'Invalid';
    // 状态：关闭
    const STATUS_VALID = 'Valid';

    // 是否是超级管理员：是
    const SUPER_VALID = 'Valid';
    // 是否是超级管理员：否
    const SUPER_INVALID = 'Invalid';

    protected $table = 'managers';

    protected $visible = [
        'id',
        'username',
        'real_name',
        'mobile',
        'email',
        'avatar',
        'gender',
        'status',
        'prev_login_time',
        'last_login_time',
        'created_at'
    ];

    protected $with = [
        'avatar'
    ];

    protected $hidden = array(
        'password',
        'remember_token'
    );

    // 访问权限
    public static $access_purview;

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
     * email 转为string类型
     */
    public function getEmailAttribute()
    {
        return (string) $this->attributes['email'];
    }

    /**
     * 所属的角色列表
     */
    public function roles()
    {
        return $this->belongsToMany('Role', 'role_manager', 'manager_id', 'role_id');
    }

    /**
     * 指店操作记录
     */
    public function vstoreLogs()
    {
        return $this->morphMany('VstoreLog', 'user');
    }

    /**
     * 用户拥有的权限
     */
    public function getAccessPurview()
    {
        if (empty(static::$access_purview) || static::$access_purview->isEmpty()) {
            // 获取用户所属的角色
            $role_list = $this->roles()
                ->where('status', Role::STATUS_VALID)
                ->get();
            $access_list = new \Illuminate\Database\Eloquent\Collection();
            if ($role_list) {
                foreach ($role_list as $role) {
                    // 按路由名称生成数组
                    if (! $role->purviews->isEmpty()) {
                        foreach ($role->purviews as $purview) {
                            // 如果没有相关路由
                            if (! $access_list->has($purview->purview_key)) {
                                $access = new \Illuminate\Support\Collection();
                                $access->push($purview);
                                $access_list->put($purview->purview_key, $access);
                            } else {
                                // 如果相同路由，如有不同的请求条件（purview->condition)，则为多条规则
                                $flag = true;
                                foreach ($access_list->get($purview->purview_key) as $sub) {
                                    if (empty($purview->condition)) {
                                        if (empty($sub->condition)) {
                                            $flag = false;
                                            break;
                                        }
                                    } else {
                                        $diff = array_diff_assoc($purview->condition, $sub->condition);
                                        if (empty($diff)) {
                                            $flag = false;
                                            break;
                                        }
                                    }
                                }
                                $flag && $access_list->get($purview->purview_key)->push($purview);
                            }
                        }
                    }
                }
            }
            static::$access_purview = $access_list;
        }

        return static::$access_purview;
    }

    /**
     * 根据给定的条件判断有没有访问权限
     */
    public static function checkAccess($key, $condition = [])
    {
        // 超级管理员不用进行验证
        if (Auth::check() && Auth::user()->is_super == Manager::SUPER_VALID) {
            return true;
        }
        if (is_null(static::$access_purview) || (empty(static::$access_purview) && static::$access_purview->isEmpty())) {
            return false;
        }
        if (! static::$access_purview->has($key)) {
            return false;
        }
        if (empty($condition)) {
            return true;
        }
        foreach (static::$access_purview->get($key) as $purview) {
            if (empty($purview->condition)) {
                return true;
            }
            $diff = array_diff_assoc($condition, $purview->condition);
            if (empty($diff)) {
                return true;
            }
        }
        return false;
    }
}
