<?php
use Carbon\Carbon;

class UserController extends BaseController
{

    /**
     * 登录页面
     */
    public function showLogin()
    {
        $data = EnterpriseConfig::whereEnterpriseId($this->enterprise_id)->first();
        return View::make('user.login')->withData($data);
    }

    /**
     * 登录处理
     */
    public function postLogin()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), array(
            'username' => [
                'required',
                'exists:managers,username'
            ],
            'password' => [
                'required',
                'between:6,16'
            ]
        ), [
            'username.required' => '用户名不能为空',
            'username.exists' => '用户名不存在',
            'password.required' => '密码不能为空',
            'password.between' => '密码位数必须是在6-16位之间'
        ]);

        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        // 登录验证。
        if (! Auth::attempt([
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ])) {
            return '用户名与密码不匹配';
        }

        // 填充登录时间
        $manager = Auth::user();
        if (is_null($manager->last_login_time)) {
            $manager->prev_login_time = new Carbon();
            $manager->last_login_time = new Carbon();
            $manager->save();
        } else {
            $manager->prev_login_time = $manager->last_login_time;
            $manager->last_login_time = new Carbon();
            $manager->save();
        }

        // 登录成功
        return $manager;
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

    /**
     * 修改密码视图
     */
    public function getPassword()
    {
        return View::make('user.password');
    }

    /**
     * 登陆状态下，通过旧密码修改到新密码。
     */
    public function postPassword()
    {
        $validator = Validator::make(Input::all(), [
            'new_password' => [
                'required',
                'between:6,16',
                'confirmed'
            ],
            'password' => [
                'required',
                'between:6,16'
            ]
        ], [
            'new_password.required' => '新密码不能为空',
            'new_password.between' => '新密码位数必须是6-16位之间',
            'new_password.confirmed' => '两次输入的新密码不一致',
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

        return $user;
        // return Redirect::route("GetModifyPassword")->withMessageSuccess('修改成功，建议您重新登录');
    }

    /**
     * 搜索用户
     */
    public function ajaxSearchUser()
    {
        $list = [];
        if (Input::has('username')) {
            $member_ids = Member::where('username', 'like', '%' . Input::get('username') . '%')->orWhere('mobile', Input::get('username'))->lists('id');
            if (! empty($member_ids)) {
                $list = MemberInfo::with('member')->whereIn('member_id', $member_ids)->get();
            }
        }

        return $list;
    }

    /**
     * 获取企业会员列表
     */
    public function getList()
    {
        $list = MemberInfo::with('member')->latest();

        // 会员名过滤
        if (Input::has('real_name')) {
            $list->where('real_name', 'like', "%" . Input::get('real_name') . "%");
        }

        // 手机号过滤
        if (Input::has('mobile')) {
            $list->where('mobile', Input::get('mobile'));
        }

        // 注册状态
        if (Input::has('status')) {
            $status = Input::get('status');
            if ($status == 'yes') {
                $list->where('member_id', '!=', 0);
            } else {
                $list->where('member_id', 0);
            }
        }

        $list = $list->paginate(20)->appends(Input::all());
        return View::make('user.list')->with(compact('list'));
    }

    /**
     * 添加新会员
     */
    public function getEditMember()
    {
        // 获取会员信息
        if (Input::get('member_id')) {
            $member_info = MemberInfo::find(Input::get('member_id'));
        }
        return View::make('user.edit')->with(compact('member_info'));
    }

    /**
     * 保存会员信息
     */
    public function postSaveMember()
    {
        $validator = Validator::make(Input::all(), [
            'real_name' => [
                'required'
            ],
            'mobile' => [
                'required',
                'unique:member_info,mobile,' . Input::get('id')
            ],
            'birthday' => [
                'required',
                'date'
            ],
            'gender' => [
                'required',
                'in:' . Member::GENDER_FEMALE . ',' . Member::GENDER_MAN
            ],
            ''
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        if (Input::has('id')) {
            $info = MemberInfo::findorNew(Input::get('id', 0));
            // 判断系统中是否已经有该手机号了
            $member = Member::where('mobile', Input::get('mobile'))->first();
            if (! empty($member)) {
                $info->member_id = $member->id;
            }
        } else {
            $info = new MemberInfo();
            $info->kind = MemberInfo::KIND_OFFLINE;
        }
        $info->real_name = Input::get('real_name');
        $info->member_sn = Input::get('member_sn', '');
        $info->mobile = Input::get('mobile');
        $info->birthday = Input::get('birthday');
        $info->gender = Input::get('gender');
        $info->remark = Input::get('remark');
        $info->deleted_at = NULL;
        $info->save();

        return $info;
    }

    /**
     * 删除会员
     */
    public function postDelete()
    {
        $validator = Validator::make(Input::all(), [
            'member_id' => [
                'required',
                'exists:member_info,id'
            ]
        ], [
            'member_id.required' => '请选择要删除的会员',
            'member_id.exists' => '系统没有相关会员信息'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $member = MemberInfo::find(Input::get('member_id'));
        $member->delete();

        return 'success';
    }

    /**
     * 批量导入会员
     */
    public function postMultiImportMember()
    {
        if (! Input::hasFile('file')) {
            return Redirect::route('StoreList')->with('message_error', '请先选择文件后在进行提交！');
        }
        $num = 0;
        Excel::selectSheetsByIndex(0)->filter('chunk')
            ->load(Input::file('file'))
            ->chunk(100, function ($results) use(&$num)
        {
            // 批量写入数据库
            foreach ($results->toArray() as $row) {
                if (empty($row[1]) || empty($row[4]) || empty($row[5]) || $row[1] == '会员姓名') {
                    continue;
                }
                empty($row[2]) && $row[2] = '';
                empty($row[3]) && $row[3] = '';
                empty($row[6]) && $row[6] = 0;
                empty($row[7]) && $row[7] = 0;
                empty($row[8]) && $row[8] = '';
                // 判断手机号是否正确
                if (! preg_match('/^1[34578][\d]{9}$/', $row[5])) {
                    continue;
                }
                // 判断会员表中是否已经有此手机号了
                $member_info = MemberInfo::where('mobile', $row[5])->first();
                $member = null;
                if (empty($member_info)) {
                    $member_info = new MemberInfo();

                    // 判断会员之前是否已经有注册了
                    $member = Member::where('mobile', $row[5])->first();
                    if (! empty($member)) {
                        $member_info->member_id = $member->id;
                    }
                    $member_info->mobile = $row[5];
                }
                $member_info->real_name = $row[1];
                $member_info->gender = ucfirst($row[4]);
                $member_info->member_sn = $row[2];
                $member_info->birthday = $row[3];
                $member_info->kind = MemberInfo::KIND_OFFLINE;
                $member_info->remark = $row[8];
                $member_info->deleted_at = NULL;
                $member_info->save();
                ++ $num;

                if (! empty($row[6]) || ! empty($row[7])) {
                    // 分发内购额和指币
                    $this->assignResource($member, $row[5], $row[6], $row[7]);
                }
            }
        });

        return Redirect::route('ManageMember')->with('message_success', "上传成功，共成功导入{$num}个会员！");
    }

    /**
     * 导入会员时分发内购额和指币
     */
    protected function assignResource($member, $mobile, $coin, $insource)
    {
        // 未注册保存到分发缓存表中
        if (empty($member)) {
            if (! empty($coin) || ! empty($insource)) {
                $rd = ResourceDispense::where('mobile', $mobile)->first();
                if (empty($rd)) {
                    $rd = new ResourceDispense();
                    $rd->mobile = $mobile;
                    $rd->coin = $coin;
                    $rd->insource = $insource;
                    $rd->save();
                } else {
                    $rd->increment('coin', $coin);
                    $rd->increment('insource', $insource);
                }
            }
        } else {
            // 已有注册直接分发
            if (! empty($insource)) {
                $i = new Insource();
                $i->member()->associate($member);
                $i->amount = $insource;
                $i->key = 'enterprise_grant';
                $i->remark = "企业赠送";
                $i->save();

                Event::fire('insource.grant', [
                    $i,
                    Auth::user()
                ]);
            }

            if (! empty($coin)) {
                $c = new Coin();
                $c->member()->associate($member);
                $c->amount = $coin;
                $c->key = 'enterprise_grant';
                $i->remark = "企业赠送";
                $c->save();

                Event::fire('coin.grant', [
                    $c,
                    Auth::user()
                ]);
            }
        }
    }
}
