<?php

/**
 * 聊天控制器
 */
class ChatController extends BaseController
{

    /**
     * 发布消息
     */
    public function postSpeak()
    {
        $validator = Validator::make(Input::all(), [
            'receiver' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ],
            'kind' => [
                'required',
                'in:' . Chat::KIND_TEXT . ',' . Chat::KIND_PICTURE . ',' . Chat::KIND_AUDIO
            ],
            'content' => [
                'required_without_all:audio_id,picture_id'
            ],
            'picture_id' => [
                'required_without_all:content,audio_id'
            ],
            'audio_id' => [
                'required_without_all:content,picture_id'
            ]
        ], [
            'receiver.required' => '接收人不能为空',
            'receiver.exists' => '接收人不存在',
            'kind.required' => '消息类型不能为空',
            'kind.in' => '消息类型必须是文字、图片或者音频',
            'content.required_without_all' => '当图片和音频内容不存在的时候，必须填写文字内容',
            'picture_id.required_without_all' => '当文字和音频内容不存在的时候，必须图片内容',
            'audio_id.required_without_all' => '当文字和图片不存在的时候，必须音频内容'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $chat = new Chat();
        $chat->sender = Auth::user()->id;
        $chat->receiver = Input::get('receiver');
        $chat->kind = Input::get('kind');
        $chat->content = Input::get('content', '');
        $chat->picture_id = Input::get('picture_id', '');
        $chat->audio_id = Input::get('audio_id', '');
        $chat->status = Chat::STATUS_UNREAD;
        $chat->save();

        return Chat::find($chat->id);
    }

    /**
     * 获取聊天记录
     */
    public function getMessages()
    {
        $validator = Validator::make(Input::all(), [
            'user_id' => [
                'required',
                'exists:members,id'
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
            'user_id.required' => '接收人不能为空',
            'user_id.exists' => '接收人不存在',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 获取聊天记录列表
        $list = Chat::where('sender', Auth::user()->id)->where('receiver', Input::get('user_id'))
            ->orWhere(function ($query)
        {
            $query->where('sender', Input::get('user_id'))
                ->where('receiver', Auth::user()->id);
        })
            ->latest()
            ->paginate(Input::get('limit', 15))
            ->getCollection();

        // 标记未读的为已读
        if (! empty($list)) {
            $unread = [];
            $user_id = Auth::user()->id;
            $list->each(function ($m) use($unread, $user_id)
            {
                // 获取状态为未读且接受者为自己的消息ID
                if ($m->status != Chat::STATUS_READ && $m->receiver == $user_id) {
                    $unread[] = $m->id;
                }
            });

            // 标记为已读
            if (! empty($unread)) {
                Chat::whereIn('id', $unread)->save([
                    'status',
                    Chat::STATUS_READ
                ]);
            }

            // 反转记录
            $list = $list->reverse();
        }

        return $list;
    }

    /**
     * 获取未读的消息列表（IOS轮询用）
     */
    public function getUnreadMessages()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ]
        ], [
            'friend_id.required' => '发送者不能为空',
            'friend_id.exists' => '发送者不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return Chat::where('sender', Input::get('friend_id'))->where('receiver', Auth::user()->id)
            ->where('status', Chat::STATUS_UNREAD)
            ->oldest()
            ->get();
    }

    /**
     * 获取聊天历史记录
     */
    public function getHistory()
    {
        $validator = Validator::make(Input::all(), [
            'relationship' => [
                'in:Attention,None'
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
            'relationship.in' => '关系必须是在Attention和None之间选择',
            'limit.integer' => '每页记录数必须是一个整数',
            'limit.between' => '每页记录数必须在1-200之间',
            'page.integer' => '页数必须是一个整数',
            'page.min' => '页数必须大于0'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $page = Input::get('page', 1);
        $limit = Input::get('limit', 15);

        $user_id = Auth::user()->id;

        // 获取用户的好友列表
        $friend_list = Auth::user()->attentions()
            ->where('relationship', Attention::RELATIONSHIP_MUTUAL)
            ->lists('friend_id');

        if (Input::has('keyword')) {
            $list = Chat::with('receiver_user')->where('content', 'like', '%' . Input::get('keyword') . '%')->where(function($q) {
                $q->where('receiver', Auth::user()->id)->orWhere('sender', Auth::user()->id);
            })->latest()->get();
        } else {
            // 按发布者分组获取发布消息的最大ID
            $max_ids = Chat::select(DB::raw('max(id) as id,IF(sender=' . Auth::user()->id . ', concat(sender, "-", receiver), concat(receiver, "-", sender)) as s_r'));
            if (! Input::has('relationship')) {
                $max_ids = $max_ids->where('receiver', Auth::user()->id)->orWhere('sender', Auth::user()->id);
            } else {
                if (Input::get('relationship') == 'Attention') {
                    $friend_list[] = $user_id;
                    $max_ids = $max_ids->whereIn('sender', $friend_list)
                        ->whereIn('receiver', $friend_list)
                        ->where(function ($q)
                        {
                            $q->where('receiver', Auth::user()->id)
                                ->orWhere('sender', Auth::user()->id);
                        });
                } else {
                    $friend_list = array_diff($friend_list, array(
                        $user_id
                    ));
                    if (! empty($friend_list)) {
                        $max_ids = $max_ids->whereNotIn('sender', $friend_list)
                            ->whereNotIn('receiver', $friend_list)
                            ->where(function ($q)
                            {
                                $q->where('receiver', Auth::user()->id)
                                    ->orWhere('sender', Auth::user()->id);
                            });
                    } else {
                        $max_ids = $max_ids->where(function ($q)
                        {
                            $q->where('receiver', Auth::user()->id)
                                ->orWhere('sender', Auth::user()->id);
                        });
                    }
                }
            }
            // 按分布者分组获取发布消息的最大ID
            $max_ids = $max_ids->groupBy('s_r')
                ->skip(($page - 1) * $limit)
                ->take($limit)
                ->lists('id');
            $list = [];
            if (! empty($max_ids)) {
                // 获取各用户最后一条聊天信息
                $list = Chat::with('receiver_user')->whereIn('id', $max_ids)->latest()->get();
            }
        }


        // 返回消息列表
        if (empty($list) || $list->isEmpty()) {
            return [];
        }
        // 把自己为发送者的模型调整为接受者
        $list->each(function (&$msg)
        {
            if ($msg->sender_user->id == Auth::user()->id) {
                unset($msg->sender_user);
                $msg->receiver = Auth::user()->id;
                $msg->sender_user = $msg->receiver_user;
                $msg->status = Chat::STATUS_READ;
            }
        });

        return $list;
    }

    /**
     * 设置消息为已读
     */
    public function postSetRead()
    {
        // 获取要设置的消息ID
        $chat_id = array_filter(explode(',', Input::get('chat_id')));
        $sender = Input::get('sender');
        $validator = Validator::make(compact('chat_id', 'sender'), [
            'chat_id' => [
                'required_without:sender',
                'exists:' . Config::get('database.connections.own.database') . '.chats,id'
            ],
            'sender' => [
                'required_without:chat_id'
            ]
        ], [
            'chat_id.required_without' => '当发送人为空，则聊天ID不能为空',
            'chat_id.exists' => '聊天ID不存在',
            'sender.required_without' => '当聊天ID为空，则发送人不能为空'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        // 修改消息为已读
        if (! empty($chat_id)) {
            Chat::whereIn('id', $chat_id)->update([
                'status' => Chat::STATUS_READ
            ]);
        } else
            if (! empty($sender)) {
                Chat::where('sender', $sender)->where('receiver', Auth::user()->id)->update([
                    'status' => Chat::STATUS_READ
                ]);
            }

        return Response::make('success');
    }

    /**
     * 删除跟某用户的聊天室
     */
    public function postRemoveChat()
    {
        $validator = Validator::make(Input::all(), [
            'friend_id' => [
                'required',
                'exists:members,id,deleted_at,NULL'
            ]
        ], [
            'friend_id.required_without' => '接收者或发送者不能为空',
            'friend_id.exists' => '接收者或发送者不存在'
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $user_id = Auth::user()->id;
        $friend_id = Input::get('friend_id');

        // 用户和指定用户的所有聊天记录
        $temp = Chat::whereRaw("(sender={$user_id} and receiver={$friend_id}) or (sender={$friend_id} and receiver={$user_id})")->get();
        if ($temp->isEmpty()) {
            return Response::make('没有找到跟此用户有关的聊天记录，删除失败', 402);
        }
        Chat::whereRaw("(sender={$user_id} and receiver={$friend_id}) or (sender={$friend_id} and receiver={$user_id})")->delete();
        return Response::make('success');
    }

    /**
     * 获取未读的消息数
     */
    public function getUnreadNum()
    {
        // 获取用户的好友列表
        $friend_list = Auth::user()->attentions()
            ->where('relationship', Attention::RELATIONSHIP_MUTUAL)
            ->lists('friend_id');

        // 获取不是好友的未读消息数
        if (empty($friend_list)) {
            $num = Chat::where('receiver', Auth::user()->id)->where('status', Chat::STATUS_UNREAD)->count();
        } else {
            $num = Chat::where('receiver', Auth::user()->id)->whereNotIn('sender', $friend_list)
                ->where('status', Chat::STATUS_UNREAD)
                ->count();
        }

        return $num;
    }
}