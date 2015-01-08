<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Smt\Alipay\Alipay;

/**
 * 支付宝控制器
 *
 * @author robote
 *
 */
class AlipayController extends BaseController
{

    /**
     * 支付宝返回
     */
    public function postNotify()
    {
        require_once ("../workbench/smt/alipay/src/Smt/Alipay/alipay.config.php");
        require_once ("../workbench/smt/alipay/src/Smt/Alipay/lib/alipay_notify.class.php");

        $input = Input::all();

        // 计算得出通知验证结果
        $alipayNotify = new AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();

        /*
         * $file="file.txt"; foreach($input as $k => $v){ //缓存 file_put_contents($file,$k.":".$v."\n\r",FILE_APPEND);//写入缓存 }
         */

        if ($verify_result) { // 验证成功
                              // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                              // 请在这里加上商户的业务逻辑程序代
                              // ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            // 获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
            if ($input['trade_status'] == 'TRADE_FINISHED' || $input['trade_status'] == 'TRADE_SUCCESS') {
                // 判断该笔订单是否在商户网站中已经做过处理
                // 如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                // 如果有做过处理，不执行商户的业务程序

                // 注意：
                // 该种交易状态只在两种情况下出现
                // 1、开通了普通即时到账，买家付款成功后。
                // 2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。

                // 调试用，写文本函数记录程序运行情况是否正常
                // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

                // ——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

                $order = Order::find($input['out_trade_no']);

                // 不修改已完成流程的订单
                if ($order->status != Order::STATUS_PENDING_PAYMENT) {
                    echo 'success';
                }
                // 检查订单总金额与支付金额是否一致
                if (! ($order->amount == $input['total_fee'])) {
                    // 填加一笔支付异常记录
                    $order_log = new OrderLog();
                    $order_log->order_id = $order->id;
                    $order_log->content = sprintf('订单支付金额异常，应支付 %s 实际支付 %s 。', $order->amount, $input['total_fee']);
                    $order_log->original_status = Order::STATUS_PENDING_PAYMENT;
                    $order_log->current_status = Order::STATUS_ERROR;
                    $order_log->save();

                    // 返回失败
                    // return 'fail';
                }

                // 记录到log文件
                // file_put_contents($file,'delivery'.":".$order->delivery."\n\r",FILE_APPEND);//写入缓存

                // 更新定单状态
                $order->delivery == Order::DELIVERY_ELECTRONIC ? $order->status = Order::STATUS_PREPARING_FOR_SHIPMENT : $order->status = Order::STATUS_PROCESSING;
                $order->out_trade_no = $input['trade_no'];
                $order->payment_time = new Carbon\Carbon();
                $order->save();

                $order = Order::find($order->id);

                // 支付成功，则进行任务奖励
                if ($order->status == Order::STATUS_PREPARING_FOR_SHIPMENT || $order->status == Order::STATUS_PROCESSING) {
                    // 发送消息到指店
                    // 通知卖家客户买家成功付款订单
                    Event::fire('messages.payment_order', $order);
                }

                echo "success"; // 请不要修改或删除

                // ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            } else {
                // 验证失败
                echo "fail";

                // 调试用，写文本函数记录程序运行情况是否正常
                // logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
        }
    }

    /**
     * 支付宝网页支付页面
     */
    public function postPayForm()
    {
        $order_id = Input::get("order_id");

        $validator = Validator::make(Input::all(), array(
            'order_id' => 'required|exists:' . Config::get('database.connections.own.database') . '.orders,id'
        ), array(
            'order_id.required' => '订单不能为空',
            'order_id.exists' => '订单不存在'
        ));
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $order = Order::find($order_id);

        if (! ($order->status == Order::STATUS_PENDING_PAYMENT)) {
            return Response::make('订单不为待支付状态', 402);
        }
        // 订单金额
        $amount = $order->amount;

        $amount = 0.01;
        // 调用alipay 支付页面
        echo Alipaywap::payment($order_id, $amount, route('AlipayNotify'), route('AlipayReturn'), $order->remark_seller);
    }

    /**
     * 支付宝网页支付结果返回页面
     */
    public function getReturn()
    {
        // 验证通知成功
        if (Alipaywap::verify() && Input::get('result') == 'success') {
            // 获取支付宝订单号
            $trade_no = Input::get('trade_no');
            // 获取支付成功时间
            $notify_time = new \Carbon\Carbon();
            // 获取系统订单号
            $order_no = Input::get('out_trade_no');
            // 修改订单的状态
            $order = Order::find($order_no);

            // 不修改已完成流程的订单
            if ($order->status == Order::STATUS_PENDING_PAYMENT) {
                // 更新定单状态
                $order->delivery == Order::DELIVERY_ELECTRONIC ? $order->status = Order::STATUS_PREPARING_FOR_SHIPMENT : $order->status = Order::STATUS_PROCESSING;
                $order->out_trade_no = $trade_no;
                $order->payment_time = $notify_time;
                $order->save();
                return View::make('alipay.payment_success');
            }
        }
        return View::make('alipay.message')->withMessage('订单支付出现异常，<a href="###">请重新支付！</a>');
    }

    /**
     * 支付宝网页支付,填写订单表单（测试用）
     */
    public function getPayForm()
    {
        return View::make('alipay.pay_form');
    }

    /**
     * 绑定支付宝接口，新增&修改
     */
    public function postBindingAlipay()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'alipay_account_id' => 'exists:alipay_accounts,id',
            'alipay_account' => 'required|alipay_account|unique:alipay_accounts,alipay_account,' . Input::get('alipay_account_id', 0),
            'alipay_username' => 'required',
            'is_default' => 'required|in:' . join(',', [
                AlipayAccount::ISDEFAULT,
                AlipayAccount::UNDEFAULT
            ])
        ], [
            'alipay_account_id.exists' => '您修改的支付宝账户不存在',
            'alipay_account.required' => '支付宝帐号不能为空',
            'alipay_account.unique' => '此支付宝账户已经存在',
            'alipay_username.required' => '支付宝用户名不能为空',
            'is_default.required' => '是否默认不能为空',
            'is_default.in' => '是否默认只能在' . AlipayAccount::ISDEFAULT . '和' . AlipayAccount::UNDEFAULT . '之间进行选择'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        $alipay_account = AlipayAccount::findOrNew(Input::get('alipay_account_id', 0));
        $alipay_account->member()->associate(Auth::user());
        $alipay_account->alipay_account = Input::get('alipay_account');
        $alipay_account->alipay_username = Input::get('alipay_username');
        $alipay_account->is_default = Input::get('is_default', AlipayAccount::UNDEFAULT);
        $alipay_account->save();

        return AlipayAccount::find($alipay_account->id);
    }

    /**
     * 删除支付宝账户
     */
    public function deleteAlipayAccount()
    {
        // 验证输入。
        $validator = Validator::make(Input::all(), [
            'alipay_account_id' => 'required|exists:alipay_accounts,id,member_id,' . Auth::id()
        ], [
            'alipay_account_id.required' => '支付宝账户不能为空',
            'alipay_account_id.exists' => '支付宝账户不存在'
        ]);
        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }
        // 执行删除
        AlipayAccount::find(Input::get('alipay_account_id'))->delete();
        return 'success';
    }

    /**
     * 获取支付宝列表接口
     */
    public function getAlipayAccountList()
    {
        // 返回参数模型
        return Auth::user()->alipayAccounts()
            ->orderBy('is_default', 'asc')
            ->get();
    }

    /**
     * 获取某个支付宝账户信息
     */
    public function getAlipayAccountInfo()
    {
        $validator = Validator::make(Input::all(), [
            'alipay_account_id' => [
                'required',
                'exists:alipay_accounts,id,member_id,' . Auth::id()
            ]
        ]);

        if ($validator->fails()) {
            return Response::make($validator->messages()->first(), 402);
        }

        return AlipayAccount::find(Input::get('alipay_account_id'));
    }

    /**
     * 获取用户默认支付宝账户
     */
    public function getDefaultAlipayAccount()
    {
        return AlipayAccount::where('member_id', Auth::id())->whereIsDefault(AlipayAccount::ISDEFAULT)->first();
    }
}