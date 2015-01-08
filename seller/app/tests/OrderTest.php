<?php

class OrderTest extends TestCase {

    /**
     * 测试评价订单
     */
//    public function testComment()
//    {
//        $this->be(Member::find(1));
//        $rs = $this->action('post', 'OrderController@postCommentOrder', [
//            'order_id' => 5,
//            'evaluation' => [
//                1 => 5
//            ],
//            'content' => [
//                1 => '测试评价'
//            ]
//        ]);
//        echo $rs->getContent();
//    }

    /**
     * 测试订单支付
     */
    public function testPayment()
    {
        $rs = $this->action('post', 'AlipayController@postNotify', [
            'trade_status' => 'TRADE_FINISHED',
            'out_trade_no' => '201411082731767139',
            'total_fee' => '392.2',
        ]);

        echo $rs->getContent();
    }

}
