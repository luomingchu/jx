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
Event::listen('insource.grant', function ($insource, $enterprise, $push_message = true)
{
    $message = new Message();
    $message::$push_message = $push_message;
    $message->member()->associate($insource->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->description = $enterprise->username."赠送你{$insource->amount}内购额。";
    $message->save();
    $message::$push_message = true;
});

/**
 * 金币分发
 */
Event::listen('coin.grant', function ($coin, $enterprise, $push_message = true)
{
    $message = new Message();
    $message::$push_message = $push_message;
    $message->member()->associate($coin->member);
    $message->type = Message::TYPE_SYSTEM;
    $message->specific = Message::SPECIFIC_COMMON;
    $message->description = $enterprise->username."赠送你{$coin->amount}个指币。";
    $message->save();
    $message::$push_message = true;
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
