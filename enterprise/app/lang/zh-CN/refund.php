<?php

return [
    'status' => [
        Refund::STATUS_WAIT_STORE_AGREE => '退货申请待确认',
        Refund::STATUS_STORE_REFUSE_BUYER => '拒绝退货申请',
        Refund::STATUS_WAIT_BUYER_RETURN_GOODS => '等待买家发货',
        Refund::STATUS_WAIT_STORE_CONFIRM_GOODS => '等待确认收货',
        Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT => '等待还款',
        Refund::STATUS_SUCCESS => '退款成功',
        Refund::TYPE_GOODS => [
            Refund::STATUS_WAIT_STORE_AGREE => '退货申请待确认',
            Refund::STATUS_STORE_REFUSE_BUYER => '拒绝退货申请',
            Refund::STATUS_WAIT_BUYER_RETURN_GOODS => '等待买家发货',
            Refund::STATUS_WAIT_STORE_CONFIRM_GOODS => '等待确认收货',
            Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT => '等待企业还款',
            Refund::STATUS_SUCCESS => '退款成功'
        ],
        Refund::TYPE_MONEY => [
            Refund::STATUS_WAIT_STORE_AGREE => '退款申请待确认',
            Refund::STATUS_STORE_REFUSE_BUYER => '拒绝退款申请',
            Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT => '等待企业还款',
            Refund::STATUS_SUCCESS => '退款成功'
        ],
    ]
];