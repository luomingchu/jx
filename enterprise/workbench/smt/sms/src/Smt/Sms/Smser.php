<?php
namespace Smt\Sms;

use Closure;
use Illuminate\Log\Writer;
use Illuminate\View\Environment;
use Illuminate\Queue\QueueManager;
use Illuminate\Container\Container;

/**
 * 短信接口
 *
 * @author Latrell Chan
 *
 */
class Smser
{

    /**
     * The view environment instance.
     *
     * @var \Illuminate\View\Environment
     */
    protected $views;

    /**
     * The log writer instance.
     *
     * @var \Illuminate\Log\Writer
     */
    protected $logger;

    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * Indicates if the actual sending is disabled.
     *
     * @var bool
     */
    protected $pretending = false;

    /**
     * Array of failed recipients.
     *
     * @var array
     */
    protected $failedRecipients = array();

    /**
     * The QueueManager instance.
     *
     * @var \Illuminate\Queue\QueueManager
     */
    protected $queue;

    /**
     * Create a new Smser instance.
     *
     * @param \Illuminate\View\Environment $views
     * @return void
     */
    public function __construct(Container $container, $views)
    {
        $this->container = $container;
        $this->views = $views;
    }

    /**
     * Send a new message using a view.
     *
     * @param string|array $view
     * @param array $data
     * @param string|array $mobile
     * @return int
     */
    public function send($mobiles, $view, array $data = null)
    {
        $content = $this->getView($view, $data);

        if (is_array($mobiles)) {
            $mobiles = implode(', ', $mobiles);
        }

        return $this->sendSmsMessage($content, $mobiles);
    }

    /**
     * Send a Sms Message instance.
     *
     * @param \Swift_Message $message
     * @return int
     */
    protected function sendSmsMessage($content, $mobiles)
    {
        if (! $this->pretending) {
            $sendmsg = $this->sendsms($mobiles, $content);
            return $sendmsg;
        } elseif (isset($this->logger)) {
            $this->logMessage($mobiles);
            return 1;
        }
    }

    /**
     * Send sms operating.
     *
     * @param string $moblie
     * @param string $content
     * @return boolean
     */
    function sendsms($moblie, $content)
    {
        $sn = $this->container['config']->get('sms::sn'); // 提供的账号
        $pwd = strtoupper(md5($this->container['config']->get('sms::sn') . $this->container['config']->get('sms::pwd')));
        $data = array(
            'sn' => $sn, // 提供的账号
            'pwd' => $pwd, // 此处密码需要加密 加密方式为 md5(sn+password) 32位大写
            'mobile' => $moblie, // 手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content' => $content . $this->container['config']->get('sms::signature'), // 短信内容
            'ext' => '',
            'stime' => '', // 定时时间 格式为2011-6-29 11:09:21
            'rrid' => '', // 默认空 如果空返回系统生成的标识串 如果传值保证值唯一 成功则返回传入的值
            'msgfmt' => ''
        );

        $url = "http://sdk.entinfo.cn:8061/webservice.asmx/mdsmssend?";

        $retult = $this->api_notice_increment($url, $data);

        preg_match('/<string.*?>(.*?)<\/string>/i', $retult, $str);
        $result = explode('-', $str[1]);

        return count($result) > 1 ? false : true;
    }

    /**
     * Call sms api.
     *
     * @param string $url
     * @param array $data
     * @return mixed
     */
    function api_notice_increment($url, $data)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
                                                       // curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        $data = http_build_query($data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $lst = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl); // 捕抓异常
        }
        curl_close($curl);
        return $lst;
    }

    /**
     * Log that a message was sent.
     *
     * @param \Swift_Message $message
     * @return void
     */
    protected function logMessage($mobiles)
    {
        $this->logger->info("Pretending to sms message to: {$mobiles}");
    }

    /**
     * Render the given view.
     *
     * @param string $view
     * @param array $data
     * @return \Illuminate\View\View
     */
    protected function getView($view, $data)
    {
        $content = $view;
        try {
            $content = $this->views->make($view, $data)->render();
        } catch (\InvalidArgumentException $e) {}
        return $content;
    }

    /**
     * Tell the mailer to not really send messages.
     *
     * @param bool $value
     * @return void
     */
    public function pretend($value = true)
    {
        $this->pretending = $value;
    }

    /**
     * Get the view environment instance.
     *
     * @return \Illuminate\View\Environment
     */
    public function getViewEnvironment()
    {
        return $this->views;
    }

    /**
     * Get the array of failed recipients.
     *
     * @return array
     */
    public function failures()
    {
        return $this->failedRecipients;
    }

    /**
     * Set the log writer instance.
     *
     * @param \Illuminate\Log\Writer $logger
     * @return \Smt\Sms\Mailer
     */
    public function setLogger(Writer $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Set the queue manager instance.
     *
     * @param \Illuminate\Queue\QueueManager $queue
     * @return \Illuminate\Mail\Mailer
     */
    public function setQueue(QueueManager $queue)
    {
        $this->queue = $queue;

        return $this;
    }
}