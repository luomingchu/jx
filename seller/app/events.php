<?php

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
 * 取消订单事件
 */
Event::listen('messages.cancel_order', function ($order)
{
    // 通知卖家客户取消订单
    $message = new Message();
    $message->member()->associate($order->vstore->member);
    $message->description = $order->member->username . '取消了订单' . $order->id;
    $message->type = Message::TYPE_STORE;
    $message->specific = Message::SPECIFIC_ORDER;
    $message->body()->associate($order);
    $message->save();
});

/**
 * 订单确认收货
 */
Event::listen('messages.receipt_order', function ($order)
{
    // 通知卖家客户确认收货
    $message = new Message();
    $message->member()->associate($order->vstore->member);
    $message->description = $order->member->username . '确认收货了订单：' . $order->id;
    $message->type = Message::TYPE_STORE;
    $message->specific = Message::SPECIFIC_ORDER;
    $message->body()->associate($order);
    $message->save();
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

/**
 * 回答问题
 */
Event::listen('messages.answer_question', function ($answer)
{
    // 通知问题的发布者您的问题被回答
    $message = new Message();
    $message->member()->associate($answer->question->member);
    $message->description = $answer->member->username . "回答了你的问题" . $answer->question->title;
    $message->type = Message::TYPE_COMMUNITY;
    $message->specific = Message::SPECIFIC_ANSWER;
    $message->body()->associate($answer);
    $message->save();
});

/**
 * 采纳回答
 */
Event::listen('messages.accept_answer', function ($answer)
{
    // 通知回答问题的人
    $message = new Message();
    $message->member()->associate($answer->member);
    $message->description = $answer->question->member->username . "采纳了你的回答";
    $message->type = Message::TYPE_COMMUNITY;
    $message->specific = Message::SPECIFIC_ACCEPT;
    $message->body()->associate($answer);
    $message->save();
});

/**
 * 请求做为指店推荐人
 */
Event::listen('messages.apply_open_store', function ($vstore)
{
    // 通知被请求推荐人
    $message = new Message();
    $message->member()->associate($vstore->referrer);
    $message->description = $vstore->member->username . "申请您作为他（她）指店的推荐人";
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_SPONSOR;
    $message->body()->associate($vstore);
    $message->save();
});

/**
 * 同意作为指定推荐人
 */
Event::listen('messages.agree_open_store', function ($vstore)
{
    // 通知被请求推荐人
    $message = new Message();
    $message->member()->associate($vstore->member);
    $message->description = $vstore->referrer->username . "已同意做为您的指店的推荐人";
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->save();
});

/**
 * 拒绝作为指定推荐人
 */
Event::listen('messages.reject_open_store', function ($vstore)
{
    // 通知被请求推荐人
    $message = new Message();
    $message->member()->associate($vstore->member);
    $message->description = $vstore->referrer->username . "已拒绝做为您的指店的推荐人";
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->save();
});

/**
 * 申请加为好友
 */
Event::listen('messages.apply_friend', function ($attention)
{
    // 通知被请求人
    $message = new Message();
    $message->member()->associate(Member::find($attention->friend_id));
    $message->description = $attention->member->username . '申请添加你为指友';
    $message->type = Message::TYPE_COMMUNITY;
    $message->specific = Message::SPECIFIC_FOLLOW;
    $message->body()->associate($attention);
    $message->save();
});

/**
 * 同意加为好友
 */
Event::listen('messages.agree_friend', function ($attention)
{
    // 通知请求人
    $message = new Message();
    $message->member()->associate(Member::find($attention->friend_id));
    $message->description = $attention->member->username . '已加你为指友';
    $message->type = Message::TYPE_COMMUNITY;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->save();
});

/**
 * 退款退货通知，通知对应指店
 */
Event::listen('messages.refund.to_vstore', function ($refund,$refund_log)
{
    // 通知申请退款退款的消费者
    $message = new Message();
    $message->member()->associate($refund->vstore);
    $message->description = $refund_log->content;
    $message->type = Message::TYPE_STORE;
    $message->specific = Message::SPECIFIC_REFUND;
    $message->body()->associate($refund);
    $message->save();
});

/**
 * 退款退货通知，仅通知消费者用户，
 */
Event::listen('messages.refund.to_vstore', function ($refund,$refund_log)
{
    // 通知申请退款退款的消费者
    $message = new Message();
    $message->member()->associate($refund->member);
    $message->description = $refund_log->content;
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_REFUND;
    $message->body()->associate($refund);
    $message->save();
});

/**
 * 关注指店后默认关注该指店店主为指友，当取消关注，根据方总监说指友关系还在 by jois
 */
Event::listen('vstore.attentioned.attention.firend', function ($vstore_id)
{
    // 关注指店后默认关注该指店指友
    $friend_id = Vstore::find($vstore_id)->member_id;
    if ($friend_id != Auth::user()->id) {
        // 查看是否已经有关注该指店店主
        $attention = Attention::where('member_id', Auth::user()->id)->where('friend_id', $friend_id)->first();
        if (is_null($attention)) {
            $attention = new Attention();
            $attention->friend_id = $friend_id;
            $attention->member()->associate(Auth::user());
            $attention->save();
        }
    }
});


/**
 * 内购额转赠
 */
Event::listen('insource.grant', function ($insource)
{
    $message = new Message();
    $message->member()->associate($insource->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->description = "恭喜您获得{$insource->remark} {$insource->amount}内购额" ;
    $message->save();
});


/**
 * 指币分发
 */
Event::listen('coin.grant', function ($coin)
{
    $message = new Message();
    $message->member()->associate($coin->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->description = "恭喜您获得{$coin->remark} {$coin->amount}个指币";
    $message->save();
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
 * 取消订单时加回用户的内购额
 */
Event::listen('order.add_back_user_source', function ($order, $member)
{
    if (! empty($order->use_coin)) {
        $coin = new Coin();
        $coin->member()->associate($member);
        $coin->amount = $order->use_coin;
        $coin->key = 'cancel_order';
        $coin->save();
    }

    // 获取内购额比率值
    $ratio_of_inner_purchase = Configs::where('key', 'ratio_of_inner_purchase')->pluck('keyvalue');

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
        // 记录内购额
        $insource = new Insource();
        $insource->member()->associate($member);
        $insource->amount = $amount;
        $insource->key = 'cancel_order';
        $insource->remark = "取消订单{$order->id}的商品，共计：{$amount}元";
        $insource->save();
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
//            $cart_info->goods_sku->price = $activity_goods->discount_price;
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
 * 通知指店、门店退款、退货申请提示
 */
Event::listen('refund.apply', function($refund)
{
    // 通知指店
    if ($refund->member->id != $refund->vstore->member->id) {
        $message = new Message();
        $message->member()->associate($refund->vstore);
        $message->type = Message::TYPE_STORE;
        $message->specific = Message::SPECIFIC_REFUND;
        $message->body()->associate($refund);
        if ($refund->type == Refund::TYPE_GOODS) {
            $message->description = "{$refund->member->username}申请的商品，退货/退款编号：{$refund->id},进行了退货申请，详情请查看。";
        } else {
            $message->description = "{$refund->member->username}申请的商品，退货/退款编号：{$refund->id},进行了退款申请，详情请查看。";
        }
        $message->save();
    }

    // 通知门店
    $message = new Message();
    $message->member()->associate($refund->store);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_REFUND;
    $message->body()->associate($refund);
    if ($refund->type == Refund::TYPE_GOODS) {
        $message->description = "{$refund->member->username}申请的商品，退货/退款编号：{$refund->id},请您进入处理。";
    } else {
        $message->description = "{$refund->member->username}申请的商品，退货/退款编号：{$refund->id},请您进入处理。";
    }
    $message->save();
});


/**
 * 检测指店等级
 */
Event::listen('order.vstore_upgrade', function($order)
{
    // 获取当前企业的所有门店等级信息
    $vstore_level = VstoreLevel::all();

    if ($vstore_level->isEmpty()) {
        return true;
    }

    // 获取指定的指店的所有交易总额
    $amount = Order::where('vstore_id', $order->vstore_id)->where('status', Order::STATUS_FINISH)->sum('amount');
    // 获取指定的指店的所有退款金额
    $refund_amount = Order::where('vstore_id', $order->vstore_id)->where('status', Order::STATUS_FINISH)->sum('refund_amount');

    // 获取指定的指店的交易成功单数
    $number = Order::where('vstore_id', $order->vstore_id)->where('status', Order::STATUS_FINISH)->count();

    // 获取指定的指店的交易总商品数
    $goods_count = Order::where('vstore_id', $order->vstore_id)->where('status', Order::STATUS_FINISH)->sum('goods_count');
    $refund_quantity = Order::where('vstore_id', $order->vstore_id)->where('status', Order::STATUS_FINISH)->sum('refund_quantity');

    $level = 0;
    // 判断等级
    foreach ($vstore_level as $vl) {
        if ($amount >= $vl->turnover || $number >= $vl->trade_count) {
            $level = $vl->level;
        }
    }

    // 修改指定指店的等级
    $trade_quantity = $goods_count - $refund_quantity;
    $trade_amount = $amount - $refund_amount;

    $vstore = Vstore::find($order->vstore_id);
    $vstore->trade_quantity = $trade_quantity < 0 ? 0 : $trade_quantity;
    $vstore->trade_amount = $refund_amount < 0 ? 0 : $trade_amount;
    $vstore->level = $level;
    $vstore->save();
});


/**
 * 检测会员等级
 */
Event::listen('order.member_upgrade', function($order)
{
    // 获取当前企业的所有门店等级信息
    $level_list = Level::all();

    if ($level_list->isEmpty()) {
        return true;
    }

    // 获取指定的指店的所有交易总额
    $amount = Order::where('member_id', $order->member_id)->where('status', Order::STATUS_FINISH)->sum('amount');
    // 获取指定的指店的所有退款金额
    $refund_amount = Order::where('member_id', $order->member_id)->where('status', Order::STATUS_FINISH)->sum('refund_amount');

    // 获取指定的指店的交易成功单数
    $number = Order::where('member_id', $order->member_id)->where('status', Order::STATUS_FINISH)->count();

    $level = 0;
    // 判断等级
    foreach ($level_list as $vl) {
        if ($amount-$refund_amount >= $vl->turnover || $number >= $vl->trade_count) {
            $level = $vl->level;
        }
    }

    // 修改订单会员的等级
    $member_info = MemberInfo::where('member_id', $order->member_id)->first();
    $member_info->level = $level;
    $member_info->save();

    return true;
});