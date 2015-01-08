1、请先到/app/config/packages/smt/baidupush/config.php文件中，配置好百度云推送的API key和Secret key。

2、运行迁移 php artisan migrate --bench="smt/baidupush" 生成记录平台用户ID和百度用户ID的绑定关系表

3、用户登录绑定使用：

Bdpush::bindUser(用户ID, 百度云推送userId, 百度云推送channel_id, 设备信息-可不传)

4、消息通知类型：

\Smt\Baidupush\Baidupush::MESSAGE_TYPE_TO_NOTICE_BAR ：消息推送到手机的通知栏中
\Smt\Baidupush\Baidupush::MESSAGE_TYPE_TO_APP ：消息推送到集成sdk的APP中

5、附加消息信息数组：

[特定关键字key]
title: 通知标题，可以为空；如果为空则设为appid对应的应用名；

notification_builder_id: Android客户端自定义通知样式，如果没有设置默认为0; 自定义样式：http://developer.baidu.com/wiki/index.php?title=docs/cplat/push/console#.E8.87.AA.E5.AE.9A.E4.B9.89.E6.A0.B7.E5.BC.8F

notification_basic_style: 只有notification_builder_id为0时才有效，才需要设置；如果没有设置默认为7；响铃：0100B=0x04 振动：0010B=0x02 可清除：0001B=0x01 可以对上述三种基本样式做“或”运算

open_type: 点击通知后的行为，1: 表示打开Url；2: 表示打开应用，如果pkg_content有定义，则按照自定义行为打开应用，如果pkg_content无定义，则启动app的launcher activity

pkg_content: 只有open_type为2时才有效,Android端SDK会把pkg_content字符串转换成Android Intent,通过该Intent打开对应app组件，所以pkg_content字符串格式必须遵循Intent uri格式，最简单的方法可以通过Intent方法toURI()获取

custom_content: 只有open_type为2时才有效,键值对形式，这些键值对将以Intent中的extra进行传递。

url: 只有open_type为1时才有效，为需要打开的url地址，当有url存在是会默认设置open_type为1。

user_confirm: 只有open_type为1时才有效，1: 表示打开url地址时需要经过用户允许；0：默认值，表示直接打开url地址不需要用户允许

还可以是其他任意的键值对，都会附加进消息中。


6、推送消息：IOS只支持消息栏通知

    A、广播消息使用：
    Bdpush::broadcastMsg('要通知的消息内容', 附加消息信息数组, 消息通知类型- 默认为穿透消息);

    B、推送到指定的用户
    Bdpush::pushMessageByUid('要通知的消息内容', 要推送的用户ID, 附加消息信息数组, 消息通知类型- 默认为穿透消息);

    C、推送到指定的组
    Bdpush::pushMessageByGroup('要通知的消息内容', 要推送的分组名, 附加消息信息数组, 消息通知类型- 默认为穿透消息);


7、分组的相关设置：

    A、设置分组
    Bdpush::setTag('分组名', 要分组的用户ID数组);

    B、删除分组
    Bdpush::deleteTag('分组名');

    C、查询分组
    Bdpush::fetchTag([查选的分组名，可不传]);

    D、查看用户所属分组
    Bdpush::queryUserTags(用户ID);

8、获取错误信息：
Bdpush::getError();
返回一个数组：
[
    'errno' => 错误号,
    'errmsg' => 错误消息,
    'request_id' => 请求ID
]