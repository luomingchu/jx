<?php
/**
 * 管理员管理控制器
 */
class ManagerController extends BaseController
{

    /**
     * 获取管理员列表
     */
    public function getList()
    {
        $list = Manager::paginate(15);
        return View::make('manager.list')->with(compact('list'));
    }

    /**
     * 添加管理员
     */
    public function getEdit($manager_id = '')
    {
        $info = empty($manager_id) ? [] : Manager::find($manager_id);
        return View::make('manager.edit')->with(compact('info'));
    }

    /**
     * 保存管理员信息
     */
    public function postSave()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'username' => [
                    'required',
                    'unique:managers,username,'.Input::get('id').',id,deleted_at,NULL'
                ],
                'password' => [
                    'required_without:id',
                    'min:6'
                ],
                'email' => [
                    'email'
                ],
                'mobile' => [
                    'regex:/^1[34578][\d]{9}$/',
                    'unique:managers,mobile,'.Input::get('id').',id,deleted_at,NULL'
                ]
            ],
            [
                'username.required' => '登录用户名不能为空',
                'username.exists' => '已经有相关的管理员登录名了',
                'password.required_without' => '登录密码不能为空',
                'password.min' => '登录密码至少为6为字符',
                'email.email' => '邮箱地址格式不正确',
                'mobile.regex' => '手机格式不正确',
                'mobile.unique' => '已经有相同的手机号了'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $manager = Manager::findOrNew(Input::get('id', 0));

        $manager->username = Input::get('username');
        Input::has('password') && $manager->password = Input::get('password');
        Input::has('real_name') && $manager->real_name = Input::get('real_name');
        Input::has('mobile') && $manager->mobile = Input::get('mobile');
        Input::has('email') && $manager->email = Input::get('email');
        Input::has('gender') && $manager->gender = Input::get('gender');
        Input::has('status') && $manager->status = Input::get('status');
        $manager->save();

        return $manager;
    }

    /**
     * 删除管理员
     */
    public function postDelete()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'manager_id' => [
                    'required',
                    'exists:managers,id'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $manager = Manager::find(Input::get('manager_id'));
        // 企业超级管理员不能删除
        if ($manager->is_super == Manager::SUPER_VALID) {
            return Response::make('系统初识账号不能删除', 402);
        }
        $manager->delete();
        return 'success';
    }

    /**
     * 切换管理员状态
     */
    public function postToggleStatus()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'manager_id' => [
                    'required',
                    'exists:managers,id'
                ],
                'status' => [
                    'required',
                    'in:'.Manager::STATUS_INVALID.','.Manager::STATUS_VALID
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $manager = Manager::find(Input::get('manager_id'));
        $manager->status = Input::get('status') == Manager::STATUS_VALID ? Manager::STATUS_INVALID : Manager::STATUS_VALID;
        $manager->save();

        return $manager;
    }
}