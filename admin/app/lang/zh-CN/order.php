<?php
return [
    'status' => [
        Order::STATUS_PENDING_PAYMENT => '待付款',
        Order::STATUS_CANCEL => '已取消',
        Order::STATUS_PREPARING_FOR_SHIPMENT => '待发货',
        Order::STATUS_SHIPPED => '已发货',
        Order::STATUS_PROCESSING => '正在备货',
        Order::STATUS_READY_FOR_PICKUP => '随时可取',
        Order::STATUS_FINISH => '已完成'
    ]
];
