<?php
/**
 * 银行账户管理控制器
 */
class AccountController extends BaseController
{

    /**
     * 编辑平台账户信息
     */
    public function getAccountInfo()
    {
        $info = Config::get('account');

        // 获取银行列表
        $banks = Bank::all();

        return View::make('account.info')->withData($info)->withBanks($banks);
    }


    /**
     * 保存平台账户信息
     */
    public function postSave()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'bank_id' => [
                    'required',
                    'exists:banks,id'
                ],
                'number' => [
                    'required'
                ],
                'name' => [
                    'required'
                ],
                'branch_code' => [
                    'required'
                ],
                'branch_name' => [
                    'required'
                ]
            ],
            [
                'bank_id.required' => '银行类别不能为空',
                'bank_id.exists' => '所需银行不存在',
                'number' => '银行账户号不能为空',
                'name' => '开户银行账户名称不能为空',
                'branch_code' => '分行机构号不能为空',
                'branch_name' => '分行网点名称不能为空'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $data = Input::all();
        $data['bank_name'] = Bank::find(Input::get('bank_id'))->name;
        file_put_contents(app_path().'/config/account.php', '<?php return '.var_export($data, true).'; ?>');
        return 'success';
    }
}