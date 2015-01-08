<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 退款、退货申请表
        Schema::create('refunds', function (Blueprint $table)
        {
            // 申请单号
            $table->char('id', 18)
                ->primary();

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 申请人
            $table->unsignedInteger('member_id')
                ->index()
                ->default(0);

            // 申请类别
            $table->enum('type', [
                Refund::TYPE_MONEY,
                Refund::TYPE_GOODS
            ]);

            // 所属订单号
            $table->char('order_id', 18)
                ->index()
                ->default('');

            // 所属门店
            $table->unsignedInteger('store_id')
                ->index()
                ->default(0);

            // 所属指店
            $table->unsignedInteger('vstore_id')
                ->index()
                ->default(0);

            // 申请状态
            $table->enum('status', [
                Refund::STATUS_WAIT_STORE_AGREE,
                Refund::STATUS_STORE_REFUSE_BUYER,
                Refund::STATUS_WAIT_BUYER_RETURN_GOODS,
                Refund::STATUS_WAIT_STORE_CONFIRM_GOODS,
                Refund::STATUS_WAIT_ENTERPRISE_REPAYMENT,
                Refund::STATUS_SUCCESS
            ]);

            // 申请退款/货订单商品ID
            $table->unsignedInteger('order_goods_id')
                ->index()
                ->default(0);

            // 申请退款/货商品ID
            $table->unsignedInteger('goods_id')
                ->index()
                ->default(0);

            // 商品名称
            $table->string('goods_name')
                ->default('');

            // 购买商品的sku
            $table->string('goods_sku')
                ->default('');

            // 购买商品的价格
            $table->decimal('price', 10, 2)
                ->default(0);

            // 申请退货的数量
            $table->integer('quantity')
                ->default(0);

            // 购买商品的活动ID
            $table->unsignedInteger('store_activity_id')
                ->default(0);

            // 实际退款金额
            $table->decimal('refund_amount', 10, 2);

            // 买家收款账户
            $table->morphs('account');

            // 退款原因
            $table->string('reason')
                ->default('');

            // 退款备注
            $table->string('remark')
                ->default('');

            // 还款外单号
            $table->string('out_trade_no')->default('');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('refunds');
    }
}
