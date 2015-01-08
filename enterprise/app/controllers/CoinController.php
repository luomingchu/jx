<?php
/**
 * 指币控制器
 */
class CoinController extends BaseController
{

    public function getEdit()
    {
        return View::make('coin.edit');
    }

    /**
     * 按分组添加内购额
     */
    public function postAddByGroup()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'group' => [
                    'required',
                    'in:All,Staff,Vstore,Member'
                ],
                'amount' => [
                    'required',
                    'integer',
                    'min:1'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        switch (Input::get('group')) {
            case 'All' :
                MemberInfo::chunk(50, function($members)
                {
                    foreach ($members as $member) {
                        $this->assignCoin($member, Input::get('amount'));
                    }
                });
                $this->broadcastMessage($this->enterprise_info->username."赠送你".Input::get('amount')."个指币。");
                break;
            case 'Staff':
                Staff::chunk(50, function($members)
                {
                    foreach ($members as $member) {
                        if ($member->member) {
                            $coin = new Coin();
                            $coin::$apply_level = false;
                            $coin->member()->associate($member->member);
                            $coin->amount = Input::get('amount');
                            $coin->key = 'enterprise_grant';
                            $coin->save();
                            $coin::$apply_level = true;

                            Event::fire('coin.grant', [$coin, Auth::user()], false);
                        } else {
                            $rd = ResourceDispense::where('mobile', $member->mobile)->first();
                            if (empty($rd)) {
                                $rd = new ResourceDispense();
                                $rd->mobile = $member->mobile;
                                $rd->coin = Input::get('amount');
                                $rd->insource = 0;
                                $rd->save();
                            } else {
                                $rd->increment('coin', Input::get('amount'));
                            }
                        }
                    }
                });
                $this->pushMessageByGroup($this->enterprise_info->username."赠送你".Input::get('amount')."个指币。", 'staff');
                break;
            case 'Vstore' :
                Vstore::where('status', Vstore::STATUS_OPEN)->chunk(50, function($vstores)
                {
                    foreach ($vstores as $vstore) {
                        if ($vstore->member) {
                            $coin = new Coin();
                            $coin::$apply_level = false;
                            $coin->member()->associate($vstore->member);
                            $coin->amount = Input::get('amount');
                            $coin->key = 'enterprise_grant';
                            $coin->save();
                            $coin::$apply_level = true;

                            Event::fire('coin.grant', [$coin, Auth::user()], false);
                        }
                    }
                });
                $this->pushMessageByGroup($this->enterprise_info->username."赠送你".Input::get('amount')."个指币。", 'vstore');
                break;
            case 'Member' :
                $vstore = Vstore::where('status', Vstore::STATUS_OPEN)->lists('member_id');
                $level = Input::get('level', []);
                if (! empty($level)) {
                    MemberInfo::whereIn('level', $level)->chunk(50, function($members) use ($vstore)
                    {
                        foreach ($members as $member) {
                            if (!empty($member->member_id) && (in_array($member->member_id, $vstore))) {
                                continue;
                            }
                            $this->assignCoin($member, Input::get('amount'));
                        }
                    });
                    $this->pushMessageByGroup($this->enterprise_info->username."赠送你".Input::get('amount')."个指币。", "member_level_{$level}");
                } else {
                    MemberInfo::chunk(50, function($members) use ($vstore)
                    {
                        foreach ($members as $member) {
                            if (!empty($member->member_id) && (in_array($member->member_id, $vstore))) {
                                continue;
                            }
                            $this->assignCoin($member, Input::get('amount'));
                        }
                    });
                    $this->pushMessageByGroup($this->enterprise_info->username."赠送你".Input::get('amount')."个指币。", 'member');
                }
                break;
        }

        return 'success';
    }


    /**
     * 发放内购额
     */
    protected function assignCoin($memberInfo, $amount)
    {
        if ($memberInfo->member_id) {
            $coin = new Coin();
            $coin::$apply_level = false;
            $coin->member()->associate($memberInfo->member);
            $coin->amount = $amount;
            $coin->key = 'enterprise_grant';
            $coin->save();
            $coin::$apply_level = true;

            Event::fire('coin.grant', [$coin, Auth::user()], false);
        } else {
            $rd = ResourceDispense::where('mobile', $memberInfo->mobile)->first();
            if (empty($rd)) {
                $rd = new ResourceDispense();
                $rd->mobile = $memberInfo->mobile;
                $rd->coin = $amount;
                $rd->insource = 0;
                $rd->save();
            } else {
                $rd->increment('coin', $amount);
            }
        }
    }



    /**
     * 按用户添加内购额
     */
    public function postAddByMember()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'member_id' => [
                    'required',
                    'exists:member_info,member_id',
                ],
                'amount' => [
                    'required',
                    'integer',
                    'min:1'
                ]
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $members = Member::whereIn('id', (array)Input::get('member_id'))->get();
        foreach($members as $member) {
            $coin = new Coin();
            $coin->member()->associate($member);
            $coin->amount = Input::get('amount');
            $coin->key = 'enterprise_grant';
            $coin->save();

            Event::fire('coin.grant', [$coin, Auth::user()]);
        }

        return 'success';
    }


    /**
     * 查看用户内购额记录列表
     */
    public function getList()
    {
        // 获取企业的门店列表
        $stores = Store::all();

        // 获取所有类别
        $sources = Source::all();
        !$sources->isEmpty() && $sources = $sources->keyBy('key');

        $list = Coin::with('member');

        // 类型过滤
        if (Input::has('type')) {
            $list->where('type', Input::get('type'));
        }

        // 类别过滤
        if (Input::has('key')) {
            if (Input::get('key') != 'all') {
                $list->where('key', Input::get('key'));
            }
        } else {
            $list->where('key', 'enterprise_grant');
        }

        $flag = true;
        // 用户名过滤
        if (Input::has('username')) {
            $user_ids = Member::where('username', 'like', '%'.Input::get('username').'%')->lists('id');
            if (empty($user_ids)) {
                $flag = false;
            } else {
                $list->whereHas('memberInfo', function($q) use ($user_ids)
                {
                    $q->whereIn('member_id', $user_ids);
                });
            }
        }

        // 指店过滤
        if (Input::has('vstore')) {
            $vstore = Vstore::find(Input::get('vstore'));
            if (empty($vstore)) {
                $flag = false;
            } else {
                $list->whereHas('memberInfo', function($q)
                {
                    $q->where('attention_vstore_id', Input::get('vstore'));
                });
                if (! empty($vstore)) {
                    $list->orWhere(function($q) use ($vstore) {
                        $q->where('member_id', $vstore->member_id);
                    });
                }
            }
        } else if (Input::has('store')) {
            $store = Store::find(Input::get('store'));
            if (! empty($store)) {
                $vstore_list = $store->vstores()->with('member')->get();
                if (! empty($vstore_list)) {
                    $list->whereHas('memberInfo', function($q) use ($vstore_list)
                    {
                        $q->whereIn('attention_vstore_id', $vstore_list->fetch('id')->toArray());
                    });
                    $list->orWhere(function($q) use ($vstore_list)
                    {
                        $q->whereIn('member_id', $vstore_list->fetch('member.id')->toArray());
                    });
                } else {
                    $flag = false;
                }
            } else {
                $flag = false;
            }
        }

        if ($flag) {
            $list = $list->latest()->paginate(15)->appends(Input::all());;
        } else {
            $list = [];
        }

        return View::make('coin.list')->with(compact('list', 'stores', 'sources'));
    }

}