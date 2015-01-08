<?php

/**
 * 内购额控制器
 */
class InsourceController extends BaseController
{

    /**
     * 指店店主给其好友发放内购额
     */
    public function postGrant()
    {
        $validator = Validator::make(Input::all(), [
            'member_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.attentions,friend_id,member_id,' . Auth::user()->id
            ],
            'amount' => [
                'required',
                'integer',
                'max:' . Auth::user()->info->insource
            ]
        ], [
            'member_id.required' => '请指定要转赠的好友',
            'member_id.exists' => '系统没有找到您的相关好友',
            'amount.required' => '请指定要转赠的数量',
            'amount.integer' => '内购额中请输入数字字符',
            'amount.max' => '您当前的内购额不够，请重新输入'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取好友信息
        $friend_info = Member::find(Input::get('member_id'));

        // 扣除当前用户内购额
        $insource = new Insource();
        $insource::$apply_level = false;
        $insource->member()->associate(Auth::user());
        $insource->amount = - Input::get('amount');
        $insource->key = 'send_to_friend';
        $insource->remark = "转赠好友" . $friend_info->username;
        $insource->save();

        // 加到指定好友的账号上
        $remark = "好友" . Auth::user()->username . "转赠";
        if (Input::has('reason')) {
            $remark .= "，备注：" . Input::get('reason');
        }

        $insource = new Insource();
        $insource::$apply_level = false;
        $insource->member()->associate($friend_info);
        $insource->key = 'friend_grant';
        $insource->remark = $remark;
        $insource->amount = Input::get('amount');
        $insource->save();

        Event::fire('insource.grant', [
            $insource
        ]);

        return Member::find(Auth::user()->id);
    }

    /**
     * 查看内购额日志表
     */
    public function getList()
    {
        $validator = Validator::make(Input::all(), [
            'type' => [
                'in:' . Insource::TYPE_EXPENSE . ',' . Insource::TYPE_INCOME
            ],
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $list = Insource::latest()->where('member_id', Auth::id());

        if (Input::has('type')) {
            $list->where('type', Input::get('type'));
        }
        return $list->paginate(Input::get('limit', 15))->getCollection();
    }

    /**
     * 我的指币记录
     */
    public function getCoinList()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'key' => [
                'exists:' . Config::get('database.connections.own.database') . '.tasks,key,status,' . Task::STATUS_OPEN
            ],
            'type' => [
                'in:' . Insource::TYPE_EXPENSE . ',' . Insource::TYPE_INCOME
            ],
            'limit' => [
                'integer',
                'between:1,200'
            ],
            'page' => [
                'integer',
                'min:1'
            ]
        ], [
            'key.required' => 'key不能为空',
            'key.exists' => 'key不存在',
            'type.in' => '类型只能在收入和支出之间选择',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得数据模型。
        $coin = Coin::with('source');
        if (Input::has('key')) {
            $coin->whereKey(Input::get('key'));
        }
        if (Input::has('type')) {
            $coin->where('type', Input::get('type'));
        }

        // 取得单页数据。
        return $coin->whereMemberId(Auth::id())
            ->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }
}