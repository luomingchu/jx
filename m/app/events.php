<?php

/**
 * 指店审核
 */
Event::listen('messages.audit_store', function($vstore)
{
    // 通知指店申请人
    $message = new Message();
    $message->member()->associate($vstore->member);
    if ($vstore->status == Vstore::STATUS_OPEN) {
        $message->description = "您的指店已通过全部审核了，现在可以正常使用了";
    } else {
        $message->description = "您的指店申请未能通过". empty($vstore->enterprise_reject_reason) ? : '，原因：'.$vstore->enterprise_reject_reason;
    }
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->save();
});


/**
 * 内购额转赠
 */
Event::listen('insource.grant', function ($insource, $enterprise)
{
    $message = new Message();
    $message->member()->associate($insource->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->description = $enterprise->username."赠送你{$insource->amount}内购额。";
    $message->save();
});

/**
 * 金币分发
 */
Event::listen('coin.grant', function ($coin, $enterprise)
{
    $message = new Message();
    $message->member()->associate($coin->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->description = $enterprise->username."赠送你{$coin->amount}个积分。";
    $message->save();
});

/**
 * 退款申请返款确认
 */
Event::listen('refund.rebate', function($refund)
{
    // 通知买家
    $message = new Message();
    $message->member()->associate($refund->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_REFUND;
    $message->description = "您申请的商品，退货/退款编号：{$refund->id}，门店已退款，详情请查看。";
    $message->body()->associate($refund);
    $message->save();

    if ($refund->member->id != $refund->vstore->member->id) {
        // 通知指店
        $message = new Message();
        $message->member()->associate($refund->vstore->member);
        $message->type = Message::TYPE_STORE;
        $message->specific = Message::SPECIFIC_REFUND;
        $message->description = "{$refund->member->username}申请的商品，退货/退款编号：{$refund->id},门店已退款给用户。";
        $message->body()->associate($refund);
        $message->save();
    }
});


/**
 * 判断用户可参加活动的商品数量
 */
Event::listen('cart.check_join_activity_goods_num', function($vstore, $goods_info, $quantity, $member)
{
    // 获取当前的内购活动信息
    $activity_info = StoreActivity::where('status', StoreActivity::STATUS_OPEN)->where('deleted', null)->where('start_datetime', '<=', date('Y-m-d H:i:s'))->where('end_datetime', '>', date('Y-m-d H:i:s'))->where('store_id', $vstore->store->id)->first();
    $buy_goods = 0;
    $quota = 0;
    if (! empty($activity_info)) {
        // 判断当前商品在此指店中是否有做内购活动
        $activity_goods = StoreActivitiesGoods::where('store_activity_id', $activity_info->id)->where('goods_id', $goods_info->id)->first();
        if (! empty($activity_goods) && ! empty($activity_goods->quota)) {
            $quota = $activity_goods->quota;
            // 获取用户生成订单的活动商品数
            $orders = Order::where('status', '!=', Order::STATUS_CANCEL)->where('member_id', $member->id)->where('vstore_id', $vstore->id)->where('created_at', '>=', $activity_info->start_datetime)->where('created_at', '<=', $activity_info->end_datetime)->lists('id');
            $can_buy = $activity_goods->quota;
            if (! empty($orders)) {
                $buy_goods = OrderGoods::whereIn('order_id', $orders)->where('goods_id', $goods_info->id)->sum('quantity');
                // 获取可再购买活动商品数
                $can_buy = $activity_goods->quota - $buy_goods;
            }
            if ($can_buy < 1) {
                $quantity = 0;
            } else if ($can_buy < $quantity) {
                $quantity = $can_buy;
            }
        }
    }
    return [$quantity, $buy_goods, $quota];
});

/**
 * 购物时用户内购额检查
 */
Event::listen('cart.check_user_insource', function ($vstore, $goods_info, $sku, $quantity, $member)
{
    // 获取当前的内购活动信息
    $activity_info = StoreActivity::where('body_type', StoreActivity::TYPE_INNER_PURCHASE)->where('deleted', null)->where('status', StoreActivity::STATUS_OPEN)->where('start_datetime', '<=', date('Y-m-d H:i:s'))->where('end_datetime', '>', date('Y-m-d H:i:s'))->where('store_id', $vstore->store->id)->first();
    if (! empty($activity_info)) {
        // 判断当前商品在此指店中是否有做内购活动
        $activity_goods = StoreActivitiesGoods::where('store_activity_id', $activity_info->id)->where('goods_id', $goods_info->id)->first();
        if (! empty($activity_goods)) {
            // 检查的总商品数为用户可购买活动商品数的最大值
//            $quantity > $activity_goods->quota && $quantity = $activity_goods->quota;
            // 获取内购额比率值
            $ratio_of_inner_purchase = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');
            // 如果用户的内购额不足商品的内购额则不能购买
            if ($quantity * round($sku->price * floatval($activity_goods->discount) / 10 * floatval($ratio_of_inner_purchase) / 100, 2) > $member->info->insource) {
                return false;
            }
        }
    }
    return true;
});

/**
 * 生成订单时用户内购额/金币检查
 */
Event::listen('order.check_user_source', function ($goodsList, $member, $coin)
{
    // 获取内购额比率值
    $ratio_of_inner_purchase = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');

    $amount = 0;
    $use_icon = 0;
    $total = 0;
    foreach ($goodsList as $goods) {
        // 获取当前的内购活动信息
        $activity_info = StoreActivity::where('status', StoreActivity::STATUS_OPEN)->where('deleted', null)->where('start_datetime', '<=', date('Y-m-d H:i:s'))->where('end_datetime', '>', date('Y-m-d H:i:s'))->where('store_id', $goods->vstore->store->id)->first();
        $flag = true;
        if (! empty($activity_info)) {
            // 判断当前商品在此指店中是否有做内购活动
            $activity_goods = StoreActivitiesGoods::where('store_activity_id', $activity_info->id)->where('goods_id', $goods->goods->id)->first();
            if (! empty($activity_goods)) {
//                $price = $goods->quantity * $activity_goods->discount_price;
                $price = $goods->quantity * $goods->goods_sku->price * floatval($activity_goods->discount) / 10;
                $amount += $price;
                if (strtolower($coin) == 'true' && ! empty($activity_goods->coin_max_use_ratio)) {
                    $use_icon += floor($price * $activity_goods->coin_max_use_ratio);
                }
                $total += $price;
                $flag = false;
                $goods->brokerage_ratio = $activity_goods->brokerage_ratio;
            }
        }
        if ($flag) {
            $total += $goods->quantity * $goods->goods_sku->price;
        }
    }
    // 获取可使用指币数
    $has_coin = $member->info->coin;
    $has_coin > $use_icon && $has_coin = $use_icon;
    // 如果用户的总内购额不够则不能生成订单
    $insource = round(($amount - $has_coin/100) * floatval($ratio_of_inner_purchase) / 100, 2);
    if (! empty($insource) && $insource > $member->info->insource) {
        return false;
    }
    return [$amount, $has_coin, $total];
});

/**
 * 购买商品生成订单时扣除用户的内购额
 */
Event::listen('order.deduct_user_source', function ($orders, $member)
{
    // 获取内购额比率值
    $ratio_of_inner_purchase = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');

    foreach ($orders as $order) {
        // 记录指币
        if (! empty($order->use_coin)) {
            $coin = new Coin();
            $coin->member()->associate($member);
            $coin->amount = - $order->use_coin;
            $coin->key = 'buy_goods';
            $coin->save();
        }

        $amount = 0;
        if (! empty($ratio_of_inner_purchase)) {
            // 获取订单中的商品列表
            $order_goods_list = OrderGoods::where('order_id', $order->id)->get();
            foreach ($order_goods_list as $goods) {
                if (! empty($goods->store_activity_id)) {
                    // 消耗内购额数
                    $amount += round($goods->price * $goods->quantity * floatval($ratio_of_inner_purchase) / 100, 2);
                }
            }
        }

        // 记录内购额
        if (! empty($amount)) {
            $insource = new Insource();
            $insource->member()->associate($member);
            $insource->amount = - $amount;
            $insource->key = 'buy_goods';
            $insource->remark = "购买订单{$order->id}的商品，共计：{$amount}元";
            $insource->save();
        }
    }
});


/**
 * 购物车商品应用活动信息
 */
Event::listen('cart.check_activity', function($cart_info)
{
    // 获取当前的内购活动信息
    $activity_info = StoreActivity::where('status', StoreActivity::STATUS_OPEN)->where('deleted', null)->where('start_datetime', '<=', date('Y-m-d H:i:s'))->where('end_datetime', '>', date('Y-m-d H:i:s'))->where('store_id', $cart_info->vstore->store->id)->first();
    if (! empty($activity_info)) {
        // 判断当前商品在此指店中是否有做内购活动
        $activity_goods = StoreActivitiesGoods::where('store_activity_id', $activity_info->id)->where('goods_id', $cart_info->goods_id)->first();
        if (! empty($activity_goods)) {
            $ratio_of_inner_purchase = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');
            $cart_info->goods_sku->price = round($cart_info->goods_sku->price / 10 * $activity_goods->discount, 2);
            if (! empty($activity_goods->coin_max_use_ratio)) {
                $cart_info->use_coin = floor($cart_info->quantity * $cart_info->goods_sku->price * $activity_goods->coin_max_use_ratio);
            }
            if (empty($ratio_of_inner_purchase)) {
                $cart_info->use_insource = 0;
            } else {
                $cart_info->use_insource = round($cart_info->quantity * $cart_info->goods_sku->price * $ratio_of_inner_purchase / 100, 2);
            }
        }
    }
    return $cart_info;
});


/**
 * 创建订单事件
 */
Event::listen('message.create_order', function ($orders)
{
    foreach ($orders as $order) {
        // 通知指店有新的的订单
        $message = new Message();
        $message->member()->associate($order->vstore->member);
        $message->description = $order->member->username . '到你的指店购买了' . $order->goods_count . '件商品';
        $message->type = Message::TYPE_STORE;
        $message->specific = Message::SPECIFIC_ORDER;
        $message->body()->associate($order);
        $message->save();
    }
});

/**
 * 付款订单
 */
Event::listen('messages.payment_order', function ($order)
{
    // 通知卖家客户买家成功付款订单
    $message = new Message();
    $message->member()->associate($order->vstore->member);
    $message->description = $order->member->username . '已成功付款订单：' . $order->id . '，付款金额' . $order->amount . '元。';
    $message->type = Message::TYPE_STORE;
    $message->specific = Message::SPECIFIC_ORDER;
    $message->body()->associate($order);
    $message->save();
});