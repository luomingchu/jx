<?php
use Illuminate\Support\Facades\Input;

/**
 * 分享控制器
 *
 * @author jois
 */
class ShareController extends BaseController
{

    /**
     * 问题分享记录
     */
    public function getQuestionList()
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

        $favorites = Question::with('member', 'pictures')->whereHas('shares', function ($q)
        {
            $q->where('member_id', Auth::id());
        });
        if (Input::has('title')) {
            $title = trim(Input::get('title'));
            $favorites = $favorites->where('title', 'like', "%{$title}%");
        }

        return $favorites->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 指店分享记录
     */
    public function getVstoreList()
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

        $favorites = Vstore::with('store', 'member')->whereHas('shares', function ($q)
        {
            $q->where('member_id', Auth::id());
        });
        if (Input::has('name')) {
            $name = trim(Input::get('name'));
            $favorites = $favorites->where('name', 'like', "%{$name}%");
        }

        return $favorites->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 商品分享记录
     */
    public function getGoodsList()
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

        $favorites = Goods::whereHas('shares', function ($q)
        {
            $q->where('member_id', Auth::id());
        });
        if (Input::has('name')) {
            $name = trim(Input::get('name'));
            $favorites = $favorites->where('name', 'like', "%{$name}%");
        }

        return $favorites->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();
    }

    /**
     * 删除分享记录
     */
    public function deleteShare()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.shares,item_id,member_id,' . Auth::id() . ',item_type,' . Input::get('type')
            ],
            'type' => [
                'required',
                'in:' . join(',', [
                    'Question',
                    'Vstore',
                    'Goods'
                ])
            ]
        ], [
            'id.required' => '分享ID不能为空',
            'id.exists' => '分享记录不存在',
            'type.required' => '类型不能为空',
            'type.in' => '类型必须在Question、Vstore和Goods之间选择'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 执行删除
        Share::whereMemberId(Auth::id())->whereItemId(Input::get('id'))
            ->whereItemType(Input::get('type'))
            ->delete();
        return 'success';
    }

    /**
     * 分享某商品的m版url[一件商品可被多次分享]
     */
    public function shareGoodsUrl()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'goods_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.goods,id,status,' . Goods::STATUS_OPEN
            ]
        ], [
            'goods_id.required' => '商品ID不能为空',
            'goods_id.exists' => '商品不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $vstore_id = Auth::user()->info->attention_vstore_id;
        empty($vstore_id) && $vstore_id = Vstore::where('member_id', Auth::user()->id)->pluck('id');
        $goods_id = Input::get('goods_id');

        // 设置m版地址
        $http_host = explode('.', Request::server('HTTP_HOST'));
        $http_host[1] = 'm';
        $http_host = implode('.', $http_host);
        return "http://{$http_host}/goods/info/{$goods_id}/{$vstore_id}";
    }

    /**
     * 分享某商品[一件商品可被多次分享]
     */
    public function shareGoods()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'goods_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.goods,id,deleted_at,NULL,status,' . Goods::STATUS_OPEN,
            'vstore_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
        ], [
            'goods_id.required' => '商品ID不能为空',
            'goods_id.exists' => '商品不存在',
            'vstore_id.required' => '请指定该商品的所属指店',
            'vstore_id.exists' => '商品的所属指店不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 取得要收藏的商品
        $goods = Goods::whereId(Input::get('goods_id'))->whereStoreId(Vstore::find(Input::get('vstore_id'))->store_id)
            ->whereStatus(Goods::STATUS_OPEN)
            ->first();
        if (is_null($goods)) {
            return Response::make('参数错误[此商品不属于该指店]，或该商品已下架', 402);
        }

        $share = new Share();
        $share->member()->associate(Auth::user());
        $share->item()->associate($goods);
        $share->vstore_id = Input::get('vstore_id');
        $share->save();

        // 任务-分享的奖励
        // $data = Event::fire('task.reward.bykey', [
        // 'share'
        // ]);
        return $share;
    }

    /**
     * 分享某指店m版地址
     */
    public function shareVstoreUrl()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
            ]
        ], [
            'vstore_id.required' => '指店ID不能为空',
            'vstore_id.exists' => '指店不存在或未开通成功'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return URL::route('MVstoreList', array(
            'vstore_id' => Input::get('vstore_id')
        ));
    }

    /**
     * 分享某指店
     */
    public function shareVstore()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'vstore_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.vstore,id,status,' . Vstore::STATUS_OPEN
            ]
        ], [
            'vstore_id.required' => '指店ID不能为空',
            'vstore_id.exists' => '指店不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $vstore = Vstore::find(Input::get('vstore_id'));
        $share = new Share();
        $share->member()->associate(Auth::user());
        $share->item()->associate($vstore);
        $share->save();

        return $share;
    }

    /**
     * 分享某问题m版地址
     */
    public function shareQuestionUrl()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ]
        ], [
            'question_id.required' => '问题ID不能为空',
            'question_id.exists' => '问题不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return URL::route('MQuestionList', array(
            'question_id' => Input::get('question_id')
        ));
    }

    /**
     * 分享某问题
     */
    public function shareQuestion()
    {
        // 输入验证。
        $validator = Validator::make(Input::all(), [
            'question_id' => [
                'required',
                'exists:' . Config::get('database.connections.own.database') . '.questions,id,deleted_at,NULL'
            ]
        ], [
            'question_id.required' => '问题ID不能为空',
            'question_id.exists' => '问题不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $question = Question::find(Input::get('question_id'));
        $share = new Share();
        $share->member()->associate(Auth::user());
        $share->item()->associate($question);
        $share->save();

        return $share;
    }

    /**
     * 分享app下载地址
     */
    public function shareAppDownLoadUrl()
    {
        return URL::route('AppDownLoad');
    }

    /**
     * 分享主页
     */
    public function shareHomeUrl()
    {
        // 验证参数
        $validator = Validator::make(Input::all(), [
            'member_id' => 'required|exists:members,id',
            'type' => 'required|in:android,iOS'
        ], [
            'member_id.required' => '用户ID不能为空',
            'member_id.exists' => '用户不存在',
            'type.required' => 'app类型不能为空',
            'type.exists' => 'app类型只能为android或者iOS'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return URL::route('MShareHome', [
            'member_id' => Input::get('member_id'),
            'type' => Input::get('type')
        ]);
    }

    /**
     * 新手帮助页面地址
     */
    public function shareHelpUrl()
    {
        return URL::route('Help');
    }

    /**
     * 玩转指帮列表页面地址
     */
    public function shareStudyZbondListUrl()
    {
        return URL::route('StudyZbondList');
    }

    /**
     * 如果邀请好友的m版地址
     */
    public function shareStudyInviteFriendUrl()
    {
        return URL::route('StudyInviteFriend');
    }

    /**
     * 如果赚取指币的m版地址
     */
    public function shareStudyCoinUrl()
    {
        return URL::route('StudyCoin');
    }

    /**
     * 如果赚取内购额的m版地址
     */
    public function shareStudyInsourceUrl()
    {
        return URL::route('StudyInsource');
    }
}