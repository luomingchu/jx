<?php
/**
 * 消息模块
 */
class MessageController extends BaseController
{

    /**
     * 获取未读消息列表
     */
    public function getList()
    {
        $list = Message::where('member_type', 'Enterprise')->where('read', Message::READ_NO)->where('alerted', Message::ALERT_NO)->latest()->take(1)->get();
        if (! $list->isEmpty()) {
            foreach ($list as $message) {
                $message->alerted = Message::ALERT_YES;
                $message->save();
            }
        }
        return $list;
    }

    /**
     * 获取未读消息数
     */
    public function getUnreadNumber()
    {
        return Message::where('member_type', 'Enterprise')->where('read', Message::READ_NO)->count();
    }

    /**
     * 获取消息历史记录
     */
    public function getHistory()
    {
        $list = Message::where('member_type', 'Enterprise')->latest()->paginate(15);
        return View::make('message.history')->with(compact('list'));
    }

    /**
     * 删除消息
     */
    public function postDelete()
    {
        $message = Message::find(Input::get('id', 0));
        if (!empty($message)) {
            $message->delete();
        }
        return 'success';
    }


    /**
     * 自定义消息推送
     */
    public function getPushMessage()
    {
        return View::make('message.push');
    }

    /**
     * 推送自定义消息
     */
    public function postPushMessage()
    {
        $validator = Validator::make(
            Input::all(),
            [
                'content' => 'required',
                'group' => [
                    'required',
                    'in:All,Staff,Vstore,Member'
                ]
            ],
            [
                'content.required' => '推送的消息内容不能为空',
                'group.required' => '推送的类型不能为空',
                'group.in' => '推送的类型选择错误'
            ]
        );

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $result = false;
        if (Config::get("baidupush::zb_circle.apiKey")) {
            // 选择百度推送的秘钥
            Bdpush::setKind("zb_circle");
            // 当推送的用户为指店、会员时进行app消息推送
            switch (Input::get('group')) {
                case 'All' :
                    $result = Bdpush::broadcastMassage([
                        'id' => 0,
                        'member' => Member::first()->toArray(),
                        'member_type' => 'Member',
                        'read' => Message::READ_NO,
                        'type' => Message::TYPE_SYSTEM,
                        'specific' => Message::SPECIFIC_COMMON,
                        'body_id' => '',
                        'body_type' => '',
                        'description' => Input::get('content'),
                        'created_at' => date('Y-m-d H:i:s')
                    ], [
                        'handler_type' => 'notice_message'
                    ]);
                    break;
                case 'Staff':
                case 'Vstore':
                case 'Member':
                    $result = Bdpush::pushMessageByGroup([
                        'id' => 0,
                        'member' => Member::first()->toArray(),
                        'member_type' => 'Member',
                        'read' => Message::READ_NO,
                        'type' => Message::TYPE_SYSTEM,
                        'specific' => Message::SPECIFIC_COMMON,
                        'body_id' => '',
                        'body_type' => '',
                        'description' => Input::get('content'),
                        'created_at' => date('Y-m-d H:i:s')
                    ], strtolower(Input::get('group')), [
                        'handler_type' => 'notice_message'
                    ]);
            }
        }
        if (! $result) {
            return Response::make('推送消息失败，请稍后重试', 402);
        }
        return Response::make('推送消息成功');
    }
}