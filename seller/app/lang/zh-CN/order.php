<?php
return [
    'status' => [
        Order::STATUS_PENDING_PAYMENT => '待付款',
        Order::STATUS_CANCEL => '已取消',
        Order::STATUS_PREPARING_FOR_SHIPMENT => '待发货',
        Order::STATUS_SHIPPED => '已发货',
        Order::STATUS_PROCESSING => '正在备货',
        Order::STATUS_READY_FOR_PICKUP => '随时可取',
        Order::STATUS_FINISH => '已完成',
        'Commented' => '已评价',
        'Uncomment' => '未评价'
    ],
    'activity' => [
        Activity::TYPE_INNER_PURCHASE => '限时内购',
        Activity::TYPE_PRESELL => '新品预售'
    ],
    'delivery' => [
        Order::DELIVERY_ELECTRONIC => '邮寄',
        Order::DELIVERY_PICKUP => '自提'
    ]
];