<?php

/**
 * 用户控制器
 */
class UserController extends BaseController
{

    /**
     * 登录
     */
    public function login()
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
        ), [
            'username.required' => '用户名(手机号)不能为空',
            'password.required' => '密码不能为空',
            'password.between' => '密码位数必须是在6-16位之间',
            'remember_me.in' => '是否记住我只能在是与否之间选择'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $is_mobile = (boolean) preg_match('/^1[3-8][0-9]{9}$/', Input::get('username'));
        $validator->sometimes('username', [
            'exists:members,mobile'
        ], function ($input) use($is_mobile)
        {
            return $is_mobile;
        });
        $validator->sometimes('username', [
            'exists:members,email'
        ], function ($input) use($is_mobile)
        {
            return ! $is_mobile;
        });

        // 登录验证。
        if (! Auth::attempt([
            $is_mobile ? 'mobile' : 'email' => Input::get('username'),
            'password' => Input::get('password')
        ], Input::get('remember_me', 'false') == 'true')) {
            return Response::make(($is_mobile ? '手机号' : '用户名') . '与密码不匹配。', 402);
        }

        // member_info 没有数据则需要添加一条。
        $member_info = MemberInfo::where('member_id', Auth::id())->where('enterprise_id',$this->enterprise_id)->first();
        if (empty($member_info)) {
            $member_info = new MemberInfo();
            $member_info->member_id = Auth::id();
            $member_info->enterprise_id = $this->enterprise_id;
            $member_info->kind = MemberInfo::KIND_SELLER;
            $member_info->save();
        } else {
            // 剔除原来session，保证单点登录
            if (! empty($member_info->session_id)) {
                $session_file = storage_path().'/sessions/'.$member_info->session_id;
                if (file_exists($session_file)) {
                    // 删除文件
                    @unlink($session_file);
                }
            }
            $member_info->session_id = Session::getId();
        }
        $member_info->save();

        // 用户信息
        return Member::find(Auth::id());
    }

    /**
     * 退出登录状态
     */
    public function logout()
    {
        // 退出系统
        Auth::logout();
        return 'success';
    }

    /**
     * 注册
     */
    public function signup()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
           /* 'username' => [
                'required',
                'between:2,64',
                'regex:/^[^0-9][^\\s]*$/iu',
                'unique:members'
            ],*/
            'mobile' => [
                'required',
                'mobile',
                'unique:members'
            ],
            'password' => [
                'required',
                'between:6,16'
            ]
        ], array(
            /*'username.required' => '用户名不能为空',
            'username.between' => '用户名只能是2-64个字符之间',
            'username.regex' => '用户名格式不正确',
            'username.unique' => '用户名已经被注册了',*/
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'mobile.unique' => '您的手机号已经在指帮连锁注册过，请直接登陆',
            'password.required' => '密码不能为空',
            'password.between' => '密码位数必须是6-16位之间'
        ));
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 创建账户。
        $user = new Member();
        $user->mobile = Input::get('mobile');
        $user->password = Input::get('password');
        $user->save();

        // 检查企业的会员中是否已有此用户
        $userInfo = MemberInfo::where('member_id', $user->id)->where('enterprise_id',$this->enterprise_id)->first();
        if (empty($userInfo)) {
            $userInfo = new MemberInfo();
            $userInfo->member_id = $user->id;
            $userInfo->enterprise_id = $this->enterprise_id;
            $userInfo->kind = MemberInfo::KIND_SELLER;
            $userInfo->save();
        }

        // 自动登录。
        Auth::login($user);

        // 注册成功
        return Member::find(Auth::id());
    }

    /**
     * 当前登录状态验证
     */
    public function auth()
    {
        if (Auth::guest()) {
            return Response::make('请登录', 401);
        } else {
            return Member::find(Auth::id());
        }
    }

    /**
     * 获取信息
     */
    public function info()
    {
        $user = Member::with('info')->find(Input::get('user_id'));
        if (is_null($user)) {
            return Response::make('用户不存在。', 402);
        }
        return $user;
    }

    /**
     * 用户绑定云推送
     */
    public function postBindBaiduPush()
    {
        $validator = Validator::make(Input::all(), [
            'push_user_id' => [
                'required'
            ],
            'channel_id' => [
                'required'
            ],
            'kind' => [
                'in:zb_circle,fanzhuan,ceshi,jiankong,jiaxiaotong'
            ]
        ], [
            'push_user_id.required' => '百度推送用户不能为空',
            'channel_id.between' => '百度推送频道ID不能为空'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $user_info = Auth::user();

        // 判断是否有相应的推送秘钥
        if (Config::get("baidupush::zb_circle.".Config::get('database.connections.own.database').".apiKey")) {
            // 选择百度推送的秘钥
            Bdpush::setKind("zb_circle.".Config::get('database.connections.own.database'));

            // 获取原来的设置ID
            $channel_id = DB::connection('own')->table('push_bind')->where('member_id', Auth::user()->id)->pluck('channel_id');
            // 判断如果绑定的设备不一致则推送异地登录通知
            if (! empty($channel_id) && Input::get('channel_id') != $channel_id) {
                Bdpush::pushMessageByUid([
                    'id' => 0,
                    'member' => $user_info->toArray(),
                    'member_type' => 'Member',
                    'read' => Message::READ_NO,
                    'type' => Message::TYPE_SYSTEM,
                    'specific' => Message::SPECIFIC_COMMON,
                    'body_id' => '',
                    'body_type' => '',
                    'description' => '您的账号在别的客户端登陆，请确认账户安全',
                    'created_at' => date('Y-m-d H:i:s')
                ], $user_info, [
                    'handler_type' => 'notice_message'
                ]);
            }

            // 绑定新的设备
            if (Bdpush::bindUser($user_info, Input::get('push_user_id'), Input::get('channel_id'), Input::get('device_info', ''), true)) {
                // 绑定用户分组
                $tags = [];
                $vstoreInfo = Vstore::where('status', Vstore::STATUS_OPEN)->where('member_id', Auth::user()->id)->first();
                if (! empty($vstoreInfo)) {
                    $tags[] = 'vstore';
                } else {
                    $tags[] = 'member';
                    $tags[] = "member_level_{$user_info->level}";
                }

                if (Auth::user()->info->kind == MemberInfo::KIND_STAFF) {
                    $tags[] = 'staff';
                }
                Bdpush::resetUserTags(Auth::user(), $tags);

                return 'success';
            }
        }

        return Response::make('绑定失败', 402);
    }

    /**
     * 登陆状态下，通过旧密码修改到新密码。
     */
    public function postPassword()
    {
        $validator = Validator::make(Input::all(), [
            'new_password' => [
                'required',
                'between:6,16'
            ],
            'password' => [
                'required',
                'between:6,16'
            ]
        ], [
            'new_password.required' => '新密码不能为空',
            'new_password.between' => '新密码位数必须是6-16位之间',
            'password.required' => '旧密码不能为空',
            'password.between' => '旧密码位数必须是6-16位之间'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 验证旧密码是否正确
        if (! Hash::check(Input::get('password'), Auth::user()->password)) {
            return Response::make('原始密码错误', 402);
        }

        // 修改密码为新的密码
        $user = Auth::user();
        $user->password = Input::get('new_password');
        $user->save();

        // 强制所有设备退出登录。
        Auth::logout();

        return 'success';
    }


    /**
     * 绑定手机
     */
    public function postBindMobile()
    {
        $validator = Validator::make(Input::all(), [
            'mobile' => [
                'required',
                'mobile',
                'unique:members,mobile,' . Auth::user()->id
            ],
            'vcode' => [
                'required',
                'smsvcode'
            ]
        ], [
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'mobile.unique' => '手机号已经存在',
            'vcode.required' => '短信验证码不能为空',
            'vcode.smsvcode' => '短信验证码不正确'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $user = Auth::user();
        // 保存手机号信息
        $user->mobile = Input::get('mobile');
        $user->save();

        return 'success';
    }

    /**
     * 绑定邮箱
     */
    public function postBindEmail()
    {
        $validator = Validator::make(Input::all(), [
            'email' => [
                'required',
                'email',
                'unique:members,email,' . Auth::user()->id
            ],
            'vcode' => [
                'required',
                'emailvcode'
            ]
        ], [
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '邮箱已经存在',
            'vcode.required' => '邮箱验证码不能为空',
            'vcode.emailvcode' => '邮箱验证码不正确'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $user = Auth::user();
        // 保存手机号信息
        $user->email = Input::get('email');
        $user->save();

        return 'success';
    }

    /**
     * 重置密码
     */
    public function resetPassword()
    {
        // 验证手机验证码。
        $validator = Validator::make(Input::all(), [
            'mobile' => [
                'required',
                'exists:members,mobile'
            ],
            'smsvcode' => [
                'required',
                'smsvcode:mobile,final'
            ],
            'password' => [
                'required',
                'between:6,16'
            ]
        ], [
            'mobile.required' => '手机号不能为空',
            'mobile.exists' => '手机号不存在',
            'smsvcode.required' => '短信验证码不能为空',
            'smsvcode.smsvcode' => '短信验证码错误',
            'password.required' => '密码不能为空',
            'password.between' => '密码位数必须是在6-16位之间'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得该用户。
        $user = Member::where('mobile', Input::get('mobile'))->first();

        $user->password = Input::get('password');
        $user->save();

        // 强制所有设备退出登录。
        Auth::logout();

        // 返回成功信息。
        return 'success';
    }

    /**
     * 通过用户名检查短信验证码
     */
    public function checkSmsFromUsername()
    {
        // 取得该用户。
        $user = Member::where('username', Input::get('username'))->first();
        if (is_null($user)) {
            return Response::make('用户不存在。', 402);
        }

        // 验证手机验证码。
        $validator = Validator::make([
            'mobile' => $user->mobile,
            'smsvcode' => Input::get('smsvcode')
        ], [
            'mobile' => [
                'required'
            ],
            'smsvcode' => [
                'required',
                'smsvcode'
            ]
        ], [
            'mobile.required' => '手机号不能为空',
            'smsvcode.required' => '短信验证码不能为空',
            'smsvcode.smsvcode' => '短信验证码错误'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 验证通过。
        return 'success';
    }

    /**
     * 编辑信息
     */
    public function edit()
    {
        // 取得允许修改的属性列表输入值。
        $inputs = Input::only('avatar_id', 'gender','nickname', 'real_name', 'signature', 'province_id', 'city_id', 'district_id', 'birthday');

        // 验证输入。
        $validator = Validator::make($inputs, [
            'avatar_id' => [
                'exists:user_files,id'
            ],
            'gender' => [
                'in:' . Member::GENDER_MAN . ',' . Member::GENDER_FEMALE
            ],
            'age' => [
                'integer',
                'between:1,100'
            ],
            'birthday' => [
                'date'
            ]
        ], [
            'avatar_id.exists' => '头像不存在',
            'gender.in' => '性别必须是在男与女之间',
            'age.integer' => '年龄必须是一个整数',
            'age.between' => '年龄必须是1-100岁之间',
            'birthday.date' => '出生年月格式不正确'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 检查头像是否为图片。
        if (! is_null($inputs['avatar_id'])) {
            $file = UserFile::find($inputs['avatar_id']);
            if (is_null($file)) {
                $inputs['avatar_id'] = null;
            } elseif (substr($file->storage->mime, 0, 6) != 'image/') {
                return Response::make('不支持的图片格式。', 402);
            }
        }

        // 取得当前登录用户。
        $member = Auth::user();

        // 修改用户属性。
        foreach ($inputs as $key => $value) {
            if (! is_null($value)) {
                $member->$key = $value;
            }
        }

        // 如果有传递地址
        if (Input::has('province_id')) {
            $member->region_name = Province::find(Input::get('province_id'))->name;
            Input::has('city_id') && $member->region_name .= City::find(Input::get("city_id"))->name;
            Input::has('district_id') && $member->region_name .= District::find(Input::get('district_id'))->name;
        }

        // 保存修改。
        $member->save();

        return Member::find($member->id);
    }
}