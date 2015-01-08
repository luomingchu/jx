<?php

class UserController extends BaseController
{

    /**
     * 登录页面
     */
    public function showLogin()
    {
        return View::make('user.login');
    }

    /**
     * 登录处理
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
            ],
            'remember_me' => [
                'in:true,false'
            ]
        ));
        $is_mobile = (boolean) preg_match('/^1[3-8][0-9]{9}$/', Input::get('username'));
        $validator->sometimes('username', [
            'exists:admins,mobile,deleted_at,NULL'
        ], function ($input) use($is_mobile)
        {
            return $is_mobile;
        });
        $validator->sometimes('username', [
            'exists:admins,username,deleted_at,NULL'
        ], function ($input) use($is_mobile)
        {
            return ! $is_mobile;
        });
        if ($validator->fails()) {
            return Redirect::back()->withMessageError($validator->messages()
                ->first())
                ->withInput();
        }

        // 登录验证。
        if (! Auth::attempt([
            $is_mobile ? 'mobile' : 'username' => Input::get('username'),
            'password' => Input::get('password')
        ], Input::get('remember_me', 'false') == 'true')) {
            return Redirect::back()->with('message_error', ($is_mobile ? '手机号' : '用户名') . '与密码不匹配。');
        }

        // 登录成功
        return Redirect::intended();
    }

    /**
     * 退出登录状态
     */
    public function logout()
    {
        // 退出系统
        Auth::logout();
        return Redirect::route('Dashboard');
    }
}
