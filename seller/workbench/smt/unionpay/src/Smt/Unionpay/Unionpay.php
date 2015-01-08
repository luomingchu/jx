<?php
namespace Smt\Unionpay;

use Closure;
use Illuminate\Log\Writer;
use Illuminate\View\Environment;
use Illuminate\Queue\QueueManager;
use Illuminate\Container\Container;

/**
 * 手机银联支付接口
 *
 * @author Jois
 *
 */
header('Content-type:text/html;charset=UTF-8');
require_once ("lib/common.php");
require_once ("lib/log.class.php");
require_once ("lib/SDKConfig.php");
require_once ("lib/secureUtil.php");
require_once ("lib/encryptParams.php");
require_once ("lib/httpClient.php");

class Unionpay
{

    /**
     * 消费交易-前台
     */
    static public function payment($order_id, $amount, $front_url = '', $back_url = '', $subject = '')
    {
        header("Content-type:text/html;charset=utf-8");
        // 初始化日志
        $log = new PhpLog(SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL);
        $log->LogInfo("============处理前台请求开始===============");
        // 初始化日志
        $params = array(
            'version' => '5.0.0', // 版本号
            'encoding' => 'UTF-8', // 编码方式
            'certId' => getSignCertId(), // 证书ID
            'txnType' => '01', // 交易类型
            'txnSubType' => '01', // 交易子类
            'bizType' => '000000', // 业务类型
            'frontUrl' => SDK_FRONT_NOTIFY_URL, // 前台通知地址
            'backUrl' => SDK_BACK_NOTIFY_URL, // 后台通知地址
            'signMethod' => '01', // 签名方法
            'channelType' => '07', // 渠道类型
            'accessType' => '0', // 接入类型
            'merId' => '898340183980105', // 商户代码
            'orderId' => $order_id, // 商户订单号
            'txnTime' => date('YmdHis'), // 订单发送时间
            'txnAmt' => $amount * 100, // 交易金额
            'currencyCode' => '156', // 交易币种
            'orderDesc' => '购买商品', // 订单描述
            'defaultPayType' => '0001' // 默认支付方式
                );

        // 检查字段是否需要加密
        encrypt_params($params);
        // 签名
        sign($params);

        // 前台请求地址
        $front_uri = SDK_FRONT_TRANS_URL;
        $log->LogInfo("前台请求地址为>" . $front_uri);
        // 构造 自动提交的表单
        $html_form = create_html($params, $front_uri);

        $log->LogInfo("-------前台交易自动提交表单>--begin----");
        $log->LogInfo($html_form);
        $log->LogInfo("-------前台交易自动提交表单>--end-------");
        $log->LogInfo("============处理前台请求 结束===========");
        echo $html_form;
    }

    /**
     * 验签，验证支付结果
     */
    static public function verify($inputs)
    {
        if (empty($inputs)) {
            return false;
        }
        $params = array(
            'version' => '5.0.0', // 版本号
            'encoding' => 'UTF-8', // 编码方式
            'certId' => getSignCertId(), // 证书ID
            'txnType' => '01', // 交易类型
            'signMethod' => '01', // 签名方法
            'txnSubType' => '01', // 交易子类
            'bizType' => '000000', // 业务类型
            'frontUrl' => SDK_FRONT_NOTIFY_URL, // 前台台通知地址
            'backUrl' => SDK_BACK_NOTIFY_URL, // 后台通知地址
            'channelType' => '07', // 渠道类型
            'accessType' => '0', // 接入类型
            'merId' => '898340183980105', // 商户代码
            'orderId' => $inputs['order_id'], // date('YmdHis'), // 商户订单号
            'txnTime' => date('YmdHis'), // 订单发送时间
            'accType' => '01', // 账号类型
            'accNo' => '9555542160000001', // 账号
            'txnAmt' => '1230', // 交易金额
            'currencyCode' => '156' // 交易币种
                );
        // 签名
        sign($params);
        // 发送信息到后台
        $result = sendHttpRequest($params, SDK_BACK_TRANS_URL);

        // 返回结果展示
        $result_arr = coverStringToArray($result); // 字符转数组
        var_dump($result_arr);
        echo "<br /><br />";
        echo "<br /><br />";
        $r = verify($result_arr);
        echo "<br /><br />";
        echo "<br /><br />";
        echo $r;
        echo "<br /><br />";
        echo "<br /><br />";
        echo $r ? '验签成功' : '验签失败';
        $html = create_html($result_arr, SDK_BACK_NOTIFY_URL);
        echo $html;
    }

    /**
     * 查询交易状态
     */
    static public function transStatus()
    {
        // 初始化日志
        $log = new PhpLog(SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL);
        $log->LogInfo("===========处理后台请求开始============");

        $params = array(
            'version' => '5.0.0', // 版本号
            'encoding' => 'GBK', // 编码方式
            'certId' => getSignCertId(), // 证书ID
            'signMethod' => '01', // 签名方法
            'txnType' => '00', // 交易类型
            'txnSubType' => '00', // 交易子类
            'bizType' => '000000', // 业务类型
            'channelType' => '07', // 渠道类型
            'accessType' => '0', // 接入类型
            'channelType' => '07', // 渠道类型
            'orderId' => date('YmdHis'), // 商户订单号
            'merId' => '898340183980105', // 商户代码
            'accNo' => '9555542160000001', // 账号
            'txnTime' => date('YmdHis') // 订单发送时间
                );

        // 检查字段是否需要加密
        encrypt_params($params);

        // 签名
        sign($params);

        $log->LogInfo("后台请求地址为>" . SDK_BACK_TRANS_URL);
        // 发送信息到后台
        $result = sendHttpRequest($params, SDK_BACK_TRANS_URL);
        $log->LogInfo("后台返回结果为>" . $result);

        // 返回结果展示
        $result_arr = coverStringToArray($result);
        $html = create_html($result_arr, SDK_BACK_NOTIFY_URL);
        echo $html;
    }

    /**
     * 预授权交易
     */
    static public function AuthDeal($order_id, $amount, $front_url = '', $back_url = '', $subject = '')
    {
        // 初始化日志
        $log = new PhpLog(SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL);
        $log->LogInfo("============处理前台请求开始===============");

        // 初始化日志
        $params = array(
            'version' => '5.0.0', // 版本号
            'encoding' => 'UTF-8', // 编码方式
            'certId' => getSignCertId(), // 证书ID
            'signMethod' => '01', // 签名方法 01
            'txnType' => '02', // 交易类型
            'txnSubType' => '01', // 交易子类
            'bizType' => '000301', // 业务类型
            'backUrl' => SDK_BACK_TRANS_URL, // 后台通知地址
            'accessType' => '0', // 接入类型
            'channelType' => '07', // 渠道类型 07互联网 08移动
            'merId' => '898111453990182', // 商户代码
            'orderId' => $order_id, // 商户订单号
            'txnTime' => date('YmdHis'), // 订单发送时间
            'accType' => '01', // 账号类型 01银行卡
            'accNo' => '9555542160000001', // 账号
            'txnAmt' => $amount * 100, // 交易金额
            'currencyCode' => '156' // 交易币种 // 'encryptCertId' => '', //加密证书ID
                );

        // 检查字段是否需要加密
        // encrypt_params($params);
        // 签名
        sign($params);

        $log->LogInfo("后台请求地址为>" . SDK_BACK_TRANS_URL);
        // 发送信息到后台
        $result = sendHttpRequest($params, SDK_BACK_TRANS_URL);
        $log->LogInfo("后台返回结果为>" . $result);

        // 返回结果展示
        $result_arr = coverStringToArray($result);
        dd($result_arr);
        exit();
        $html = create_html($result_arr, SDK_BACK_NOTIFY_URL);
        echo $html;
    }

    /**
     * 查询交易
     */
    static public function AcpQueryDeal($order_id, $amount, $front_url = '', $back_url = '', $subject = '')
    {
        // 初始化日志
        $log = new PhpLog(SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL);
        $log->LogInfo("============处理前台请求开始===============");

        // 初始化日志
        $params = array(
            'version' => '5.0.0', // 版本号
            'encoding' => 'UTF-8', // 编码方式
            'certId' => getSignCertId(), // 证书ID
            'signMethod' => '01', // 签名方法
            'txnType' => '02', // 交易类型
            'txnSubType' => '01', // 交易子类
            'bizType' => '000301', // 业务类型
            'channelType' => '07', // 渠道类型
            'accessType' => '0', // 接入类型
            'channelType' => '07', // 渠道类型
            'orderId' => $order_id, // 商户订单号
            'merId' => '898340183980105', // 商户代码
            'accNo' => '9555542160000001', // 账号
            'txnTime' => date('YmdHis') // 订单发送时间
                );

        // 检查字段是否需要加密
        encrypt_params($params);

        // 签名
        sign($params);

        $log->LogInfo("后台请求地址为>" . SDK_BACK_TRANS_URL);
        // 发送信息到后台
        $result = sendHttpRequest($params, SDK_BACK_TRANS_URL);
        $log->LogInfo("后台返回结果为>" . $result);

        // 返回结果展示
        $result_arr = coverStringToArray($result);
        $html = create_html($result_arr, SDK_BACK_NOTIFY_URL);
        echo $html;
    }

    /**
     * 预授权完成交易
     */
    static public function AuthFinish($order_id, $amount, $front_url = '', $back_url = '', $subject = '')
    {
        // 初始化日志
        $log = new PhpLog(SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL);
        $log->LogInfo("============处理前台请求开始===============");

        $params = array(
            'version' => '5.0.0', // 版本号
            'encoding' => 'UTF-8', // 编码方式
            'certId' => getSignCertId(), // 证书ID
            'signMethod' => '01', // 签名方法
            'txnType' => '03', // 交易类型
            'txnSubType' => '01', // 交易子类
            'channelType' => '07', // 渠道类型
            'bizType' => '000301', // 业务类型
            'backUrl' => SDK_FRONT_NOTIFY_URL, // 后台通知地址
            'accessType' => '0', // 接入类型
            'merId' => '898340183980105', // 商户代码
            'orderId' => $order_id, // 商户订单号
            'origQryId' => '201303071540145467132', // 原始交易流水号
            'txnTime' => date('YmdHis'), // 订单发送时间
            'txnAmt' => $amount * 100, // 交易金额
            'currencyCode' => '156' // 交易币种
                );

        // 签名
        sign($params);

        $log->LogInfo("后台请求地址为>" . SDK_BACK_TRANS_URL);
        // 发送信息到后台
        $result = sendHttpRequest($params, SDK_BACK_TRANS_URL);
        $log->LogInfo("后台返回结果为>" . $result);

        // 返回结果展示
        $result_arr = coverStringToArray($result);
        $html = create_html($result_arr, SDK_BACK_NOTIFY_URL);
        echo $html;
    }
}