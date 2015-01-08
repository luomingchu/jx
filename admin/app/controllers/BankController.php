<?php
use Illuminate\Support\Facades\Redirect;

/**
 * 银行管理控制器
 */
class BankController extends BaseController
{

    /**
     * 获取银行列表
     */
    public function getList()
    {
        $list = Bank::orderBy('sort', 'desc')->paginate(Input::get('limit', 15));
        return View::make('bank.list')->withData($list);
    }

    /**
     * 添加银行
     */
    public function getEdit()
    {
        $bank = [];
        if (Input::has('id')) {
            $bank = Bank::find(Input::get('id'));
        }
        return View::make('bank.edit')->withData($bank);
    }

    /**
     * 保存银行信息
     */
    public function postSave()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'bank_id' => 'exists:banks,id',
            'name' => 'required',
            'logo_hash' => 'exists:storage,hash',
            'hotline' => 'integer|unique:banks,hotline,' . Input::get('bank_id'),
            'sort' => 'integer'
        ], [
            'bank_id.exists' => '此银行不存在',
            'name.required' => '银行名称不能为空',
            'logo_hash.exists' => 'logo不存在',
            'hotline.integer' => '银行服务热线格式不正确',
            'hotline.unique' => '银行服务热线已经存在',
            'sort.integer' => '排序值只能为数字'
        ]);
        if ($validator->fails()) {
            return $validator->messages()->first();
        }

        // 保存
        $bank = Input::has('bank_id') ? Bank::find(Input::get('bank_id')) : new Bank();
        $bank->name = trim(Input::get('name'));
        $bank->hotline = Input::get('hotline', '');
        $bank->remark = trim(Input::get('remark'));
        $bank->sort = Input::get('sort', 100);
        $bank->logo_hash = Input::get('logo_hash', '');
        $bank->save();

        return $bank;
    }

    /**
     * 删除银行信息
     */
    public function postDelete()
    {
        // 验证数据。
        $validator = Validator::make(Input::all(), [
            'id' => 'required|exists:banks,id'
        ], [
            'id.required' => '要删除的银行不能为空',
            'id.exists' => '要删除的银行不存在'
        ]);
        if ($validator->fails()) {
            return Redirect::route('GetBankList')->withMessageError($validator->messages()
                ->first());
        }

        // 判断是否银行是否有被用户使用
        $temp = Bankcard::whereBankId(Input::get('id'))->first();
        if (! is_null($temp)) {
            return Redirect::route('GetBankList')->withMessageError('此银行已经被用户所使用，不能删除');
        }

        // 执行删除
        Bank::find(Input::get('id'))->delete();

        // 跳转回列表页。
        return Redirect::route('GetBankList')->withMessageSuccess('银行删除成功');
    }
}