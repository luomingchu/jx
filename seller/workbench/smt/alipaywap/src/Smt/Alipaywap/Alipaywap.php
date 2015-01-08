<?php
namespace Smt\Alipaywap;
use Illuminate\Support\Facades\URL;

class Alipaywap
{
    // 配置信息
    protected $config;

    // 卖家支付宝帐户
    protected $seller_email;

    // 商家列表
    protected $kind;

    public function __construct($kind = '', $config = [])
    {
        !empty($kind) && $this->setKind($kind);
        $this->loadConfig($config);
    }

    // 获取配置信息
    public function loadConfig($config = [])
    {
        // 获取通用配置
        $alipay_config = \Config::get("alipaywap::common");
        // 获取卖家配置
        $seller_config = \Config::get("alipaywap::customer.{$this->kind}");
        // 设置最新的配置
        !empty($seller_config) && $alipay_config = array_merge($alipay_config, $seller_config);
        !empty($config) && $alipay_config = array_merge($alipay_config, $config);

        // 单独提取卖家支付宝账号
        $this->seller_email = $alipay_config['email'];
        unset($alipay_config['email']);
        $this->config = $alipay_config;
    }

    // 设置商家类别
    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function payment($order_id, $amount, $notify_url, $call_back_url, $subject = '')
    {
        require_once("lib/lib/alipay_submit.class.php");
        //返回格式
        $format = "xml";
        //必填，不需要修改

        //返回格式
        $v = "2.0";
        //必填，不需要修改

        //请求号
        $req_id = date('Ymdhis');
        //必填，须保证每次请求都是唯一

        //**req_data详细信息**

        //服务器异步通知页面路径
        //需http://格式的完整路径，不允许加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        //需http://格式的完整路径，不允许加?id=123这类自定义参数

        //操作中断返回地址
        $merchant_url = "";
        //用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数

        //卖家支付宝帐户
        $seller_email = $this->seller_email;
        //必填

        //商户订单号
        $out_trade_no = $order_id;
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        empty($subject) && $subject = '购买商品';
        //必填

        //付款金额
        $total_fee = $amount;
        //必填

        //请求业务参数详细
        $req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . $seller_email . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
        //必填

        /************************************************************/

        //构造要请求的参数数组，无需改动
        $para_token = array(
            "service" => "alipay.wap.trade.create.direct",
            "partner" => trim($this->config['partner']),
            "sec_id" => trim($this->config['sign_type']),
            "format"	=> $format,
            "v"	=> $v,
            "req_id"	=> $req_id,
            "req_data"	=> $req_data,
            "_input_charset"	=> trim(strtolower($this->config['input_charset']))
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->config);
        $html_text = $alipaySubmit->buildRequestHttp($para_token);
        //URLDECODE返回的信息
        $html_text = urldecode($html_text);

        //解析远程模拟提交后返回的信息
        $para_html_text = $alipaySubmit->parseResponse($html_text);
        //获取request_token
        $request_token = $para_html_text['request_token'];


        /**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/

        //业务详细
        $req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
        //必填

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "service" => "alipay.wap.auth.authAndExecute",
            "partner" => trim($this->config['partner']),
            "sec_id" => trim($this->config['sign_type']),
            "format"	=> $format,
            "v"	=> $v,
            "req_id"	=> $req_id,
            "req_data"	=> $req_data,
            "_input_charset"	=> trim(strtolower($this->config['input_charset']))
        );
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->config);
        $html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '');
        echo $html_text;
    }


    /**
     * 验证支付通知
     */
    public function verify()
    {
        require_once("lib/lib/alipay_notify.class.php");
        // 计算得出通知验证结果
        $alipayNotify = new AlipayNotify($this->config);
        if (empty($_POST)) {
            $verify_result = $alipayNotify->verifyReturn();
        } else {
            $verify_result = $alipayNotify->verifyNotify();
        }
        return $verify_result;
    }
}