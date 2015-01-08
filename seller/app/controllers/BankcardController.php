<?php
use Illuminate\Support\Facades\Input;

/**
 * 银行卡模块
 */
class BankcardController extends BaseController
{

    /**
     * 银行列表
     */
    public function getBankList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Bank::orderBy('sort', 'desc')->paginate(Input::get('limit', 15))->getCollection();
    }

    /**
     * 获取指定的银行卡信息
     */
    public function getInfo()
    {
        $validator = Validator::make(Input::all(), [
            'bankcard_id' => [
                'required',
                'exists:bankcards,id,member_id,' . Auth::id()
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Bankcard::with('bank', 'member')->find(Input::get('bankcard_id'));
    }

    /**
     * 获取默认的银行卡
     */
    public function getDefaultBankcard()
    {
        return Bankcard::where('member_id', Auth::id())->where('is_default', Bankcard::ISDEFAULT)->first();
    }

    /**
     * 获取用户的银行卡列表
     */
    public function getBankcardList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Bankcard::with('bank')->where('member_id', Auth::id())
            ->orderBy('is_default', 'asc')
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 保存银行卡信息
     */
    public function postSave()
    {
        // TODO:银行卡号的正则
        $validator = Validator::make(Input::all(), [
            'bankcard_id' => [
                'exists:bankcards,id,member_id,' . Auth::id()
            ],
            'bank_id' => [
                'required',
                'exists:banks,id'
            ],
            'mobile' => [
                'required',
                'mobile'
            ],
            'number' => [
                'required'
            ],
            'real_name' => [
                'required'
            ],
            'open_account_bank' => [
                'required'
            ],
            'is_default' => [
                'required',
                'in:' . join(',', [
                    Bankcard::ISDEFAULT,
                    Bankcard::UNDEFAULT
                ])
            ]
        ], [
            'bank_id.required' => '银行ID不能为空',
            'bank_id.exists' => '银行不存在',
            'bankcard_id.exists' => '银行卡不存在',
            'mobile.required' => '手机号不能为空',
            'mobile.mobile' => '手机号格式不正确',
            'number.required' => '银行卡号不能为空',
            'real_name.required' => '真实姓名不能为空',
            'open_account_bank.required' => '开户行名称不能为空',
            'is_default.required' => '是否默认不能为空',
            'is_default.in' => '是否默认只能在Yes与No之间选择'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 判断此银行此卡号是否已经存在
        $check = Bankcard::whereMemberId(Auth::id())->whereBankId(Input::get('bank_id'))
            ->whereNumber(trim(Input::get('number')))
            ->first();
        if (! is_null($check) && ! Input::has('bankcard_id')) {
            return Response::make('您已经添加了此银行卡号，不能重复添加', 402);
        }

        // 判断是否为第一次添加银行卡信息，是则强制默认
        $temp = Bankcard::whereMemberId(Auth::id())->count();

        $bankcard = Bankcard::findOrNew(Input::get('bankcard_id', 0));
        $bankcard->member()->associate(Auth::user());
        $bankcard->bank()->associate(Bank::find(Input::get('bank_id')));
        $bankcard->number = trim(Input::get('number'));
        $bankcard->mobile = Input::get('mobile');
        $bankcard->real_name = Input::get('real_name');
        $bankcard->open_account_bank = Input::get('open_account_bank');
        if ($temp == 0 && ! Input::has('bankcard_id')) {
            $bankcard->is_default = Bankcard::ISDEFAULT;
        } else {
            $bankcard->is_default = Input::get('is_default', Bankcard::UNDEFAULT);
        }
        $bankcard->save();

        return Bankcard::find($bankcard->id);
    }

    /**
     * 银行卡的删除
     */
    public function postDelete()
    {
        $validator = Validator::make(Input::all(), [
            'bankcard_id' => [
                'required',
                'exists:bankcards,id,member_id,' . Auth::id()
            ]
        ], [
            'bankcard_id.required' => '银行卡ID不能为空',
            'bankcard_id.exists' => '银行卡不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取银行卡信息
        $bankcard = Auth::user()->bankcards()->find(Input::get('bankcard_id'));
        // 删除此银行卡
        $bankcard->delete();

        // 删除后判断是否只剩下一个，是则将此设为默认
        $temp = Bankcard::whereMemberId(Auth::id())->count();
        if ($temp == 1) {
            $bankcard = Bankcard::whereMemberId(Auth::id())->whereIsDefault(Bankcard::UNDEFAULT)->first();
            if (! is_null($bankcard)) {
                $bankcard->is_default = Bankcard::ISDEFAULT;
                $bankcard->save();
            }
        }

        return 'success';
    }
}