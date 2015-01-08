<?php

class BaseController extends Controller
{

    protected $enterprise_id;

    protected $enterprise_info;

    public function __construct()
    {
        $this->enterprise_info = Enterprise::where('domain', select_enterprise())->first();
        $this->enterprise_id = $this->enterprise_info->id;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }

        // 手机号验证
        Validator::extend('mobile', function ($attribute, $value, $parameters)
        {
            if (preg_match('/^1[3|4|5|7|8][0-9]{9}$/', $value)) {
                return true;
            }
            return false;
        });
    }

    /**
     * 广播消息
     */
    public function broadcastMessage($message)
    {
        if (Config::get("baidupush::zb_circle." . Config::get('database.connections.own.database') . ".apiKey")) {
            // 选择百度推送的秘钥
            Bdpush::setKind("zb_circle." . Config::get('database.connections.own.database'));
            Bdpush::broadcastMassage([
                'id' => 0,
                'member' => Member::first()->toArray(),
                'member_type' => 'Member',
                'read' => Message::READ_NO,
                'type' => Message::TYPE_SYSTEM,
                'specific' => Message::SPECIFIC_COMMON,
                'body_id' => 0,
                'body_type' => null,
                'description' => $message,
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'handler_type' => 'notice_message'
            ]);
        }
    }

    /**
     * 按组推送消息
     */
    public function pushMessageByGroup($content, $group)
    {
        if (Config::get("baidupush::zb_circle." . Config::get('database.connections.own.database') . ".apiKey")) {
            // 选择百度推送的秘钥
            Bdpush::setKind("zb_circle." . Config::get('database.connections.own.database'));
            Bdpush::pushMessageByGroup([
                'id' => 0,
                'member' => Member::first()->toArray(),
                'member_type' => 'Member',
                'read' => Message::READ_NO,
                'type' => Message::TYPE_SYSTEM,
                'specific' => Message::SPECIFIC_COMMON,
                'body_id' => 0,
                'body_type' => null,
                'description' => $content,
                'created_at' => date('Y-m-d H:i:s')
            ], $group, [
                'handler_type' => 'notice_message'
            ]);
        }
    }
}
