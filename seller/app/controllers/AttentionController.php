<?php

/**
 * 用户关注控制器
 */
class AttentionController extends BaseController
{

    /**
     * 添加好友
     */
    public function postAttention()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ]
        ], [
            'friend_id.required' => '好友不能为空',
            'friend_id.exists' => '好友不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        if (Auth::id() == Input::get('friend_id')) {
            return Response::make('您不能自己加为好友', 402);
        }

        // 查看是否已经有关注
        $attention = Attention::where('member_id', Auth::user()->id)->where('friend_id', Input::get('friend_id'))->first();
        if (is_null($attention)) {
            $attention = new Attention();
            $attention->friend_id = Input::get('friend_id');
            $attention->member()->associate(Auth::user());
            $attention->save();

            // 发送消息给对应的用户
            if ($attention->relationship == Attention::RELATIONSHIP_UNILATERAL) {
                // 如果为申请好友
                Event::fire('messages.apply_friend', [
                    $attention
                ]);
            } else
                if ($attention->relationship == Attention::RELATIONSHIP_MUTUAL) {
                    // 如果为答应加好友请求
                    Event::fire('messages.agree_friend', [
                        $attention
                    ]);
                }
        }

        return Attention::find($attention->id);
    }

    /**
     * 删除好友
     */
    public function postRemove()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ]
        ], [
            'friend_id.required' => '好友不能为空',
            'friend_id.exists' => '好友不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 查看是否已经有关注
        $attention = Attention::where('member_id', Auth::user()->id)->where('friend_id', Input::get('friend_id'))->first();
        if (! empty($attention)) {
            $attention->delete();
        }
        return 'success';
    }

    /**
     * 获取好友列表
     */
    public function getList()
    {
        $list = Attention::with('friend.avatar')->where('member_id', Auth::user()->id)
            ->where('relationship', Attention::RELATIONSHIP_MUTUAL)
            ->get();

        return $list;
    }

    /**
     * 获取新的好友请求数
     */
    public function getInviteNum()
    {
        return Attention::where('friend_id', Auth::user()->id)->where('relationship', Attention::RELATIONSHIP_UNILATERAL)->count();
    }

    /**
     * 获取好友请求列表
     */
    public function getInviteList()
    {
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

        // 获取用户的关注列表
        $list = Attention::where('friend_id', Auth::user()->id)->lists('member_id');
        if (! empty($list)) {
            $list = Member::whereIn('id', $list)->get();
        }
        return $list;

        // 获取用户上传的通讯录
        $contacts = Contact::where('member_id', Auth::user()->id)->get();

        $member_list = [];

        if (! $list->isEmpty()) {
            $member_list = Member::whereIn('id', $list->fetch('member_id')->toArray())->get()->keyBy('mobile');
            $list = $list->keyBy('member_id');
        }

        $data = [];

        // 增加原来的关注列表
        if (! empty($member_list) && ! $member_list->isEmpty()) {
            foreach ($member_list as $m) {
                $data[] = [
                    'member_id' => $m->id,
                    'username' => empty($m->real_name) ? $m->username : $m->real_name,
                    'mobile' => $m->mobile,
                    'avatar' => $m->avatar,
                    'relationship' => $list->get($m->id)->relationship
                ];
            }
        }

        foreach ($contacts as $contact) {
            if (! empty($member_list) && ! $member_list->isEmpty() && ! $member_list->has('contact_phone')) {
                $m = Member::where('mobile', $contact->contact_phone)->first();
                if ($m) {
                    $data[] = [
                        'member_id' => $m->id,
                        'username' => empty($m->real_name) ? $m->username : $m->real_name,
                        'mobile' => $m->mobile,
                        'avatar' => $m->avatar,
                        'relationship' => 'Unattention'
                    ];
                } else {
                    $data[] = [
                        'member_id' => 0,
                        'username' => $contact->contact_username,
                        'mobile' => $contact->contact_phone,
                        'avatar' => null,
                        'relationship' => 'Unregistered'
                    ];
                }
            }
        }

        return array_slice($data, (Input::get('page', 1) - 1) * Input::get('limit', 20), Input::get('limit', 20));
    }

    /**
     * 搜索用户
     */
    public function getSearch()
    {
        $validator = Validator::make(Input::all(), [
            'keyword' => [
                'required'
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
            'keyword.required' => '搜索关键字不能为空',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 如果不是数字字符串则只搜索用户名
        if (! is_numeric(Input::get('keyword'))) {
            $list = Member::where('username', 'like', '%' . Input::get('keyword') . '%')->paginate(Input::get('limit', 20))->getCollection();
        } else {
            $list = Member::where('username', 'like', '%' . Input::get('keyword') . '%')->orWhere('mobile', 'like', '%' . Input::get('keyword') . '%')
                ->paginate(Input::get('limit', 20))
                ->getCollection();
        }
        return $list;
    }

    /**
     * 手机通讯录导入
     */
    public function postUploadContacts()
    {
        if (! Input::has('contacts')) {
            return Response::make('手机通讯录不能为空', 402);
        }
        // 获取通讯录列表
        $contacts = json_decode(stripcslashes(Input::get('contacts')), true);
        $data = [];
        $user_id = Auth::user()->id;
        foreach ($contacts as $phone => $username) {
            $data[] = [
                'member_id' => $user_id,
                'contact_username' => $username,
                'contact_phone' => $phone,
                'created_at' => new \Carbon\Carbon()
            ];
        }
        // 删除原来的通讯录信息
        Contact::where('member_id', $user_id)->delete();

        // 保存新的通讯录列表
        if (Contact::insert($data)) {
            return 'success';
        }
        return Response::make('上传通讯录失败', 402);
    }
}