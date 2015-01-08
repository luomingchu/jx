<?php
if (! function_exists('uniqueid')) {

    /**
     * 创建一个分布式唯一ID
     *
     * @return string
     */
    function uniqueid()
    {
        $uniqid = uniqid(gethostname(), true);
        $md5 = substr(md5($uniqid), 12, 8); // 8位md5
        $uint = hexdec($md5);
        return sprintf('%s%010u', date('Ymd'), $uint);
    }
}

if (! function_exists('db_transaction')) {

    /**
     * 分布式事务临时解决方案
     *
     * @param Closure $callback
     * @return boolean
     */
    function db_transaction(Closure $callback)
    {
        DB::transaction(function ($global) use($callback)
        {
            return $callback($global);
        });
    }
}

if (! function_exists('db_begin_transaction')) {

    /**
     * 开启分布式事务
     */
    function db_begin_transaction()
    {
        DB::beginTransaction();
    }
}

if (! function_exists('db_rollback')) {

    /**
     * 回滚分布式事务
     */
    function db_rollback()
    {
        DB::rollBack();
    }
}

if (! function_exists('db_commit')) {

    /**
     * 提交分布式事务
     */
    function db_commit()
    {
        DB::commit();
    }
}

if (! function_exists('calculate_brokerage')) {

    /**
     * 根据订单商品信息统计佣金金额
     */
    function calculate_brokerage($orderGoodsInfo)
    {
        if (is_null($orderGoodsInfo->refund) || $orderGoodsInfo->refund->status == Refund::STATUS_STORE_REFUSE_BUYER) {
            return round($orderGoodsInfo->price * $orderGoodsInfo->quantity * ($orderGoodsInfo->brokerage_ratio + $orderGoodsInfo->level_brokerage_ratio) / 100, 2);
        }
        return 0;
    }
}

if (! function_exists('round_custom')) {

    /**
     * 自定义的四舍五入
     */
    function round_custom($number, $decimal = 2)
    {
        return sprintf("%.{$decimal}f", round($number, 2));
    }
}

if (! function_exists('id_pad')) {

    /**
     * 指定长度的左边补零
     */
    function id_pad($id, $len = 6)
    {
        return str_pad($id, $len, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('select_enterprise')) {

    /**
     * 选择当前所属企业
     */
    function select_enterprise()
    {
        $host = array_get(parse_url(URL::current()), 'host');
        return current(explode('.', $host));
    }
}

if (! function_exists('enterprise_info')) {

    /**
     * 获取当前的企业信息
     */
    function enterprise_info()
    {
        $enterprise = select_enterprise();

        // 获取企业信息
        return Cache::remember("enterprise_{$enterprise}_info", 10, function () use($enterprise)
        {
            return Enterprise::where('domain', $enterprise)->first();
        });
    }
}

