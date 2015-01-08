<?php

class EnterpriseConfigController extends BaseController
{

    /**
     * 编辑企业设置
     */
    public function edit()
    {
        $data = EnterpriseConfig::whereEnterpriseId($this->enterprise_id)->first();
        return View::make('enterprise-configs.edit')->withData($data);
    }

    /**
     * 保存系统参数
     */
    public function save()
    {
        // 获取输入。
        $inputs = Input::all();

        // 验证输入。
        $validator = Validator::make($inputs, [
            'admin_logo_hash' => 'size:32',
            'login_logo_hash' => 'size:32',
            'login_big_hash' => 'size:32',
           // 'info_logo_hash' => 'size:32'
        ], [
            'admin_logo_hash.size' => '后台站头logo上传失败',
            'login_logo_hash.size' => '登录页logo上传失败',
            'login_big_hash.size' => '登录页右边大图上传失败',
            //'info_logo_hash.size' => '企业信息页面logo图片上传失败'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('message_error', $validator->messages()
                ->first())
                ->withInput();
        }

        $enterprise_config = EnterpriseConfig::whereEnterpriseId($this->enterprise_id)->first();
        if (is_null($enterprise_config)) {
            $enterprise_config = new EnterpriseConfig();
        }
        $enterprise_config->enterprise_id = $this->enterprise_id;
        $enterprise_config->admin_logo_hash = $inputs['admin_logo_hash'];
        $enterprise_config->admin_logo_hash2 = $inputs['admin_logo_hash2'];
        $enterprise_config->login_logo_hash = $inputs['login_logo_hash'];
        $enterprise_config->login_big_hash = $inputs['login_big_hash'];
       // $enterprise_config->info_logo_hash = $inputs['info_logo_hash'];
        $enterprise_config->login_color = empty($inputs['login_color']) ? '#242332' : $inputs['login_color'];
        $enterprise_config->save();

        return Redirect::route("EnterpriseConfigEdit")->withMessageSuccess('保存成功');
    }
}
