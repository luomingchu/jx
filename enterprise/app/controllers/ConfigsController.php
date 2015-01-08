<?php

class ConfigsController extends BaseController
{

    /**
     * 显示系统参数列表
     */
    public function getList()
    {
        return View::make('configs.list')->withData(Configs::where('is_show',Configs::IS_SHOW_YES)->paginate('15'));
    }

    /**
     * 编辑系统参数
     */
    public function edit($key)
    {
        return View::make('configs.edit')->withData(Configs::find($key));
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
            'key' => [
                'required',
                'exists:configs,key'
            ],
            'keyvalue' => [
                'required'
            ]
        ], [
            'key.required' => '参数key不能为空',
            'key.exists' => '参数key不存在',
            'keyvalue.required' => '参数值不能为空'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->with('message_error', $validator->messages()
                ->first())
                ->withInput();
        }

        if (Input::get('key') == 'enrefund_days') {
            if ($inputs['keyvalue'] < 7 || $inputs['keyvalue'] > 15) {
                return Redirect::back()->with('message_error', '订单可退货退款天数，它的范围只能是7-15天')->withInput();
            }
        } elseif (Input::get('key') == 'can_settlement_brokerage_days') {
            if ($inputs['keyvalue'] < 10 || $inputs['keyvalue'] > 25) {
                return Redirect::back()->with('message_error', '本月多少天后可结算上月的佣金，它的范围只能是10-25天')->withInput();
            }
        }
        $configs = Configs::find(Input::get('key'));
        $configs->keyvalue = $inputs['keyvalue'];
        $configs->remark = $inputs['remark'];
        $configs->save();

        return Redirect::route("ConfigsList")->withMessageSuccess('保存成功');
    }
}
