<?php
use Illuminate\Support\Facades\Redirect;

/**
 * 用户控制器
 */
class UserController extends BaseController
{

    /**
     * 登录页面
     */
    public function showLogin()
    {
        // 记录跳转到登录页面的url，登录后跳回去
        $rtn_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        return View::make('user.login')->withUrl($rtn_url);
    }

    /**
     * 用户登录处理
     */
    public function postLogin()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), array(
            'username' => [
                'required'
            ],
            'password' => [
                'required',
                'between:6,16'
            ]
        ), [
            'username.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'password.between' => '密码位数必须是在6-16位之间'
        ]);

        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        $is_mobile = (boolean) preg_match('/^1[3-8][0-9]{9}$/', Input::get('username'));
        $validator->sometimes('username', [
            'exists:members,mobile'
        ], function ($input) use($is_mobile)
        {
            return $is_mobile;
        });
        $validator->sometimes('username', [
            'exists:members,username'
        ], function ($input) use($is_mobile)
        {
            return ! $is_mobile;
        });

        // 登录验证。
        if (! Auth::attempt([
            $is_mobile ? 'mobile' : 'username' => Input::get('username'),
            'password' => Input::get('password')
        ], Input::get('remember_me', 'false') == 'true')) {
            return ($is_mobile ? '手机号' : '用户名') . '与密码不匹配。';
        }

        // 私有库 member_info 没有数据则需要添加一条。
        $member_info = MemberInfo::where('member_id', Auth::id())->first();

        if (empty($member_info)) {
            $member_info = new MemberInfo();
            $member_info->member_id = Auth::id();
            $member_info->real_name = Auth::user()->real_name;
            $member_info->mobile = Auth::user()->mobile;
            $member_info->level = 1;
            $member_info->gender = Auth::user()->gender;
            $member_info->birthday = Auth::user()->birthday;
            $member_info->session_id = Session::getId();
        } else {
            // 剔除原来session，保证单点登录
            if (! empty($member_info->session_id)) {
                $session_file = storage_path() . '/sessions/' . $member_info->session_id;
                if (file_exists($session_file)) {
                    // 删除文件
                    @unlink($session_file);
                }
            }
            $member_info->session_id = Session::getId();
        }
        $member_info->save();

        // 检查是否是本企业的员工
        $staffInfo = Staff::where('mobile', Auth::user()->mobile)->first();
        if ($staffInfo && empty($staffInfo->member_id)) {
            $staffInfo->member_id = Auth::user()->id;
            $staffInfo->save();

            $member_info->kind = MemberInfo::KIND_STAFF;
            $member_info->save();
        }

        // 登录成功。
        if (Input::get('rtn_url', '')) {
            return array(
                'url' => Input::get('rtn_url')
            );
        } else {
            return Auth::id();
        }
    }

    /**
     * 退出登录状态
     */
    public function logout()
    {
        // 退出系统
        Auth::logout();
        return Redirect::route('HomePage');
    }

    /**
     * 用户注册表单页
     */
    public function getSignin()
    {
        return View::make('user.signin');
    }

    /**
     * 用户注册
     *
     * @author Aaronhyq
     * @param string $mobile手机号
     * @param string $smsvcode验证码
     * @param string $password密码
     * @return 用户模型
     */
    public function postSignin()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), array(
            'mobile' => [
                'required',
                'unique:buyers,mobile',
                'mobile'
            ],
            'password' => [
                'required',
                'between:6,16'
            ],
            'smsvcode' => [
                'required',
                'smsvcode'
            ]
        ));
        if ($validator->fails()) {
            return $this->responseJson(402, $validator->messages()
                ->first());
        }

        $buyer = new Buyer();
        $buyer->username = substr(md5(Input::get('mobile')), 8, 16) . '@m';
        $buyer->mobile = Input::get('mobile');
        $buyer->password = Input::get('password');
        $buyer->save();

        // 进行自动登录
        Auth::login($buyer);

        // 注册成功。
        return $buyer;
    }
}