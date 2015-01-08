<?php  namespace Smt\Baidupush;

use Illuminate\Workbench\Starter;
use Smt\Baidupush\Lib\Channel;

class Baidupush
{

    protected $kind;
    protected $channel;
    protected $app;
    protected $pushUid;
    protected $pushUserInfo;

    // 设备标识号：android
    const DEVICE_ANDROID = 3;
    // 设备标识号：IOS
    const DEVICE_IOS = 4;

    // 推送类型：按单个人发送
    const PUSH_TYPE_SINGLE = 1;
    // 推送类型：按指定的组发送，必须指定Tag
    const PUSH_TYPE_GROUP = 2;
    // 推送类型：广播发送（所有人）
    const PUSH_TYPE_BROADCAST = 3;

    // 消息类型：透传给应用的消息体
    const MESSAGE_TYPE_TO_APP = 0;
    // 消息类型：设备上的通知栏
    const MESSAGE_TYPE_TO_NOTICE_BAR = 1;

    public function __construct($kind, $app)
    {
        $this->app = $app;
    }


    /**
     * 设置百度推送的类别
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
        $apiKey = \Config::get("baidupush::{$kind}.apiKey");
        $secretKey = \Config::get("baidupush::{$kind}.secretKey");
        $this->channel = new Channel($apiKey, $secretKey);
    }


    /**
     * 平台账号和百度推送账号绑定
     */
    public function bindUser($user, $push_user_id, $channel_id, $device_info = '', $delete=true)
    {
        \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('member_id', $user->id)->delete();
        // 查看此用户是否已经记录到指定的百度userId
        if (\DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('member_id', $user->id)->where('push_user_id', $push_user_id)->where('channel_id', $channel_id)->where('kind', $this->kind)->count() > 0) {
            return true;
        }
        // 查看指定的设备是否已绑定到其他用户
        if ($delete) {
            if (\DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('channel_id', $channel_id)->count() > 0) {
                // 删除百度用户原来绑定标签
                $this->resetUserTags($channel_id);
                \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('channel_id', $channel_id)->delete();
            }
        }


        return \DB::table(\Config::get('database.connections.own.database').'.push_bind')->insert(
            ['member_id' => $user->id,  'push_user_id' => $push_user_id, 'channel_id' => $channel_id, 'device_info' => $device_info, 'kind'=> $this->kind, 'created_at' => new \Carbon\Carbon()]
        );
    }

    /**
     * 根据channel_id获取百度推送绑定信息
     */
    public function getBindInfoWithChannel($channel_id, $with_kind=false)
    {
        if ($with_kind) {
            return \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('channel_id', $channel_id)->where('kind', $this->kind)->first();
        } else {
            return \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('channel_id', $channel_id)->first();
        }
    }

    /**
     * 广播消息
     *
     * @param $content string 消息内容
     * @param array $params 附件的通知内容
     * @param int $message_type 通知类型
     * @return array
     */
    public function broadcastMsg($content, $params = array(), $message_type = self::MESSAGE_TYPE_TO_APP)
    {
        $param = $params;
        $param['description'] = $content;
        $param['push_type'] = static::PUSH_TYPE_BROADCAST;
        $param['message_type'] = $message_type;
        return $this->pushAndroidMessage($param);
    }


    /**
     * 指定用户推送
     *
     * @param string $content 发送的消息内容
     * @param int $user 指定发送的用户
     * @param array $params 发送的附加信息数组
     * @param int $message_type 发送的消息类型
     * @return array
     */
    public function pushMessageByUid($content, $user, $params = array(), $message_type = self::MESSAGE_TYPE_TO_APP)
    {
        $param = $params;

        // 对数NULL类型进行处理。
        $recstr = function ($data) use(&$recstr)
        {
            if (is_array($data)) {
                return array_map($recstr, $data);
            } elseif ($data === null) {
                return (object) null;
            }
            return $data;
        };

        $param['description'] = $recstr($content);
//        $param['push_type'] = static::PUSH_TYPE_GROUP;
        $param['push_type'] = static::PUSH_TYPE_SINGLE;
//        $param['tag'] = strtolower(get_class($user))."_{$user->id}";
        $param['message_type'] = $message_type;

        // 获取推送的用户ID
        $info = \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('member_id', $user->id)->where('kind', $this->kind)->first();
        if ($info) {
            return $this->pushAndroidMessage($param, $info->push_user_id);
        }
        return false;


        $param = $params;
        $param['push_type'] = static::PUSH_TYPE_SINGLE;
        $param['description'] = $content;
        $param['message_type'] = $message_type;
        $response = [];

        // 获取指定用户绑定的百度用户ID
        $pushUid = $this->getPushUid($uid);
        if (!empty($pushUid)) {
            foreach ($pushUid as $pid) {
                $user_device = $this->response($this->channel->queryBindList($pid));
                // 判断用户所有绑定的设备
                if (!isset($user_device['errno'])) {
                    // 如果用户未绑定任何设备，不进行推送
                    $user_device['binds'] = $user_device['response_params']['binds'];
                    if (!empty($user_device['binds'])) {
                        // 获取绑定的设备类型 1：浏览器设备； 2：PC设备； 3：Andriod设备； 4：iOS设备； 5：Windows Phone设备；
                        $device = [];
                        foreach ($user_device['binds'] as $bind) {
                            $device[] = $bind['device_type'];
                        }
                        // 给android设备推送消息
                        if (in_array(static::DEVICE_ANDROID, $device)) {
                            $response[$pid]['android'] = $this->pushAndroidMessage($param, $pid);
                        }

                        // TODO 需iOS证书进行测试
                        // 给IOS设置推送通知
                        if (in_array(static::DEVICE_IOS, $device)) {
//                            $response[$pid]['ios'] = $this->pushIOSMessage($param, $pid);
                        }
                    }
                }
            }
            return $response;
        }

        return [
            'errno' => -404,
            'errmsg' => '用户没有绑定相关设备',
            'request_id' => $this->channel->getRequestId()
        ];
    }


    /**
     * 指定组进行推送
     * @param string $content 要推送的内容
     * @param string $group 要指定的分组名
     * @param array $params 附加的消息内容
     * @param int $message_type 发送的消息类型
     * @return array
     */
    public function pushMessageByGroup($content, $group, $params = array(), $message_type = self::MESSAGE_TYPE_TO_APP)
    {
        $param = $params;
        $param['description'] = $content;
        $param['push_type'] = static::PUSH_TYPE_GROUP;
        $param['tag'] = $group;
        $param['message_type'] = $message_type;
        return $this->pushAndroidMessage($param);
    }


    /**
     * 指定要推送的用户的userId
     */
    public function getPushUid($user_id)
    {
        is_object($user_id) && $user_id = $user_id->id;
        if (empty($this->pushUid[$user_id])) {
            $this->pushUid[$user_id] = \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('member_id', $user_id)->where('kind', $this->kind)->lists('push_user_id');
        }
        return $this->pushUid[$user_id];
    }


    /**
     * 获取指定的用户推送信息
     */
    public function getPushUserInfo($user)
    {
        $push_list = \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('member_id', $user->id)->where('kind', $this->kind)->get();
        if (! empty($push_list)) {
            foreach ($push_list as $k => $push) {
                $push->tag_list = explode(',', $push->tag_list);
                $push_list[$k] = $push;
            }
        }
        $this->pushUserInfo[$user->id] = $push_list;
        return $this->pushUserInfo[$user->id];
    }


    /**
     * 查询设备、应用、用户与百度Channel的绑定关系
     */
    public function queryBindList($user_id)
    {
        $return = [];

        foreach ($this->getPushUid($user_id) as $pid) {
            $return[] = $this->response($this->channel->queryBindList($pid));
        }

        return $return;
    }


    /**
     * 判断设备、应用、用户与Channel的绑定关系是否存在。
     */
    public function verifyBind($user_id)
    {
        $return = [];

        foreach ($this->getPushUid($user_id) as $pid) {
            $return[] = $this->response($this->channel->verifyBind($pid));
        }

        return $return;
    }


    /**
     * 推送android设备消息
     */
    public function pushAndroidMessage($param, $pushUid = '')
    {
        //指定发到android设备
        $optional[Channel::DEVICE_TYPE] = static::DEVICE_ANDROID;

        //推送消息到某个user，设置push_type = 1;
        //推送消息到一个tag中的全部user，设置push_type = 2;
        //推送消息到该app中的全部user，设置push_type = 3;
        if ($param['push_type'] == static::PUSH_TYPE_SINGLE) {
            //如果推送单播消息，需要指定user
            $optional[Channel::USER_ID] = $pushUid;
        } else if ($param['push_type'] == static::PUSH_TYPE_GROUP) {
            //如果推送tag消息，需要指定tag_name
            $optional[Channel::TAG_NAME] = $param['tag'];
        }

        //指定消息类型为通知
        $optional[Channel::MESSAGE_TYPE] = empty($param['message_type']) ? static::MESSAGE_TYPE_TO_APP : $param['message_type'];

        empty($param['notification_builder_id']) && $param['notification_builder_id'] = 0;
        empty($param['notification_basic_style']) && $param['notification_basic_style'] = 7;
        $param['pkg_name'] = 'com.smt.yy.online.edu';

        $message = $param;

        // 如果传递是一个url,则为打开一个链接
        if (!empty($param['url'])) {
            $message['open_type'] = 1;
        } else {
            $message['open_type'] = 2;
        }

        $message_key = "msg_key";
        return $this->response($this->channel->pushMessage($param['push_type'], $message, $message_key, $optional));
    }

    /**
     * 推送ios设备消息
     */
    public function pushIOSMessage($param, $pushUid = '')
    {

        //指定发到android设备
        $optional[Channel::DEVICE_TYPE] = static::DEVICE_IOS;

        //推送消息到某个user，设置push_type = 1;
        //推送消息到一个tag中的全部user，设置push_type = 2;
        //推送消息到该app中的全部user，设置push_type = 3;
        if ($param['push_type'] == static::PUSH_TYPE_SINGLE) {
            //如果推送单播消息，需要指定user
            $optional[Channel::USER_ID] = $pushUid;
        } else if ($param['push_type'] == static::PUSH_TYPE_GROUP) {
            //如果推送tag消息，需要指定tag_name
            $optional[Channel::TAG_NAME] = $param['tag'];
        }

        //指定消息类型为通知（IOS只支持消息栏通知）
        $optional[Channel::MESSAGE_TYPE] = static::MESSAGE_TYPE_TO_NOTICE_BAR;
        //如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        //旧版本曾采用不同的域名区分部署状态，仍然支持。
        $optional[Channel::DEPLOY_STATUS] = 1;

        $message = $param;

        //通知类型的内容必须按指定内容发送
        $message['aps'] = [
            'title' => $param['title'],
            'alert' => $param['description'],
            'url' => $param['url'],
            'sound' => '',
            'badge' => 0
        ];
        unset($message['title'], $message['alter'], $message['url']);

        $message_key = "msg_key";
        return $this->response($this->channel->pushMessage($param['push_type'], $message, $message_key, $optional));
    }


    /**
     * 查询离线消息的个数
     */
    public function fetchMessageCount($user_id)
    {

        $return = [];

        foreach ($this->getPushUid($user_id) as $pid) {
            $return[] = $this->response($this->channel->fetchMessageCount($pid));
        }

        return $return;
    }


    /**
     * 查询离线消息
     */
    public function fetchMessage($user_id)
    {
        $return = [];
        foreach ($this->getPushUid($user_id) as $pid) {
            $return[] = $this->response($this->channel->fetchMessage($pid));
        }

        return $return;
    }


    /**
     * 删除离线消息
     */
    public function deleteMessage($user_id, $msgIds)
    {
        $return = [];

        foreach ($this->getPushUid($user_id) as $pid) {
            $return[] = $this->response($this->channel->deleteMessage($user_id, $pid));
        }

        return $return;
    }


    /**
     * 设置用户分组
     * @param $user
     * @param $tag_name
     * @return bool
     */
    public function setTag($user, $tag_name='')
    {
        $return = [];
        empty($tag_name) && $tag_name = strtolower(get_class($user).'_'.$user->id);
        foreach ($this->getPushUserInfo($user) as $pid) {
            if ( ! in_array($tag_name, $pid->tag_list)) {
                $optional[Channel::USER_ID] = $pid->push_user_id;
                $return[] = $this->channel->setTag($tag_name, $optional);
                $tag_list = array_filter(array_merge($pid->tag_list, array($tag_name)));
                \DB::table(\Config::get('database.connections.own.database').'.push_bind')->where('id', $pid->id)->update(['tag_list' => implode(',', $tag_list)]);
            }
        }

        return $return;
    }


    /**
     * 查询应用标签
     */
    public function fetchTag($tag_name = null)
    {
        $optional[Channel::TAG_NAME] = $tag_name;
        return $this->response($this->channel->fetchTag($optional));
    }


    /**
     * 删除用户标签
     */
    public function deleteTag($tag_name, $user_id = '')
    {
        $optional = null;
        !empty($user_id) && $optional[Channel::USER_ID] = $user_id;
        return $this->response($this->channel->deleteTag($tag_name, $optional));
    }


    /**
     * 查询用户所属的标签列表
     */
    public function queryUserTags($user_id, $user_type)
    {
        $return = [];

        foreach ($this->getPushUid($user_id) as $pid) {
            $return[$pid] = $this->response($this->channel->queryUserTags($pid));
        }

        return $return;
    }


    /**
     * 重置平台用户绑定到百度推送的tag分组
     */
    public function resetUserTags($channel_id)
    {
        $bd_info = $this->getBindInfoWithChannel($channel_id, true);
        if (! empty($bd_info)) {
            // 获取用户通过此设备绑定的所有分组
            $bd_bind_tags = $this->response($this->channel->queryUserTags($bd_info->push_user_id));

            if (! empty($bd_bind_tags['tags'])) {
                foreach ($bd_bind_tags['tags'] as $tag) {
                    $this->deleteTag($tag['name'], $bd_info->push_user_id);
                }
            }
        }
    }


    /**
     * 上传iOS apns证书，使channel系统支持apns服务
     * @param $name  证书名称
     * @param $description 证书描述
     * @param $release_cert 正式版证书内容
     * @param $dev_cert 开发版证书内容
     * @return mix
     */
    public function initAppIoscert($name, $description, $release_cert, $dev_cert)
    {
        //如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        //旧版本曾采用不同的域名区分部署状态，仍然支持。
        //$optional[Channel::DEPLOY_STATUS] = 1;
        return $this->response($this->channel->initAppIoscert($name, $description, $release_cert, $dev_cert));
    }


    /**
     * 更新iOS设备的推送证书相关内容
     */
    public function updateAppIoscert($name, $description, $release_cert, $dev_cert)
    {
        //如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        //旧版本曾采用不同的域名区分部署状态，仍然支持。
        //$optional[Channel::DEPLOY_STATUS] = 1;

        $optional[Channel::NAME] = $name;
        $optional[Channel::DESCRIPTION] = $description;
        $optional[Channel::RELEASE_CERT] = $release_cert;
        $optional[Channel::DEV_CERT] = $dev_cert;
        return $this->response($this->channel->updateAppIoscert($optional));
    }


    /**
     * 查询该App server对应的iOS证书
     */
    public function queryAppIoscert()
    {
        //如果ios应用当前部署状态为开发状态，指定DEPLOY_STATUS为1，默认是生产状态，值为2.
        //旧版本曾采用不同的域名区分部署状态，仍然支持。
        //$optional[Channel::DEPLOY_STATUS] = 1;

        return $this->response($this->channel->queryAppIoscert());
    }


    /**
     * 删除iOS设备的推送证书，使得App server不再支持apns服务
     */
    public function deleteAppIoscert()
    {
        return $this->response($this->channel->deleteAppIoscert());
    }


    /**
     * 获取错误信息
     */
    public function getError()
    {
        return [
            'errno' => $this->channel->errno(),
            'errmsg' => $this->channel->errmsg(),
            'request_id' => $this->channel->getRequestId()
        ];
    }


    /**
     * 返回结果值
     */
    protected function response($ret)
    {
        if (false === $ret) {
            return $this->getError();
        }
        return $ret;
    }
}