<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 订单表
        Schema::create('orders', function (Blueprint $table)
        {
            // 订单号
            $table->char('id', 18)->primary();

            // 支付商家交易号
            $table->string('out_trade_no');

            // 所属用户
            $table->unsignedInteger('member_id')->default(0);;

            // 所属企业
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 所属指店
            $table->unsignedInteger('vstore_id')->default(0);;

            // 订单金额
            $table->decimal('amount', 10, 2)
                ->default(0);

            // 订单总退款金额
            $table->decimal('refund_amount', 10, 2)
                ->default(0);

            // 订单退款商品数
            $table->integer('refund_quantity')
                ->default(0);

            // 商品总数
            $table->integer('goods_count')
                ->default(0);

            // 交货方式
            $table->enum('delivery', [
                Order::DELIVERY_ELECTRONIC,
                Order::DELIVERY_PICKUP
            ])
                ->default(Order::DELIVERY_ELECTRONIC);

            // 订单状态
            $table->enum('status', [
                Order::STATUS_PENDING_PAYMENT,
                Order::STATUS_CANCEL,
                Order::STATUS_PREPARING_FOR_SHIPMENT,
                Order::STATUS_SHIPPED,
                Order::STATUS_PROCESSING,
                Order::STATUS_READY_FOR_PICKUP,
                Order::STATUS_FINISH,
                Order::STATUS_ERROR
            ])
                ->default(Order::STATUS_PENDING_PAYMENT);

            // 支付时间
            $table->timestamp('payment_time')
                ->nullable();

            // 订单发货时间
            $table->timestamp('delivery_time')
                ->nullable();

            // 订单结算时间
            $table->timestamp('finish_time')
                ->nullable();

            // 买家评价。
            $table->enum('commented', [
                Order::COMMENTED_NO,
                Order::COMMENTED_YES
            ])
                ->default(Order::COMMENTED_NO);

            // 买家备注
            $table->string('remark_buyer')
                ->default('');

            // 卖家备注
            $table->string('remark_seller')
                ->default('');

            // 使用指币数
            $table->integer('use_coin')
                ->default(0);

            // 订单所得佣金
            $table->decimal('brokerage', 10, 2)
                ->default(0);

            // 订单佣金结算状态
            $table->unsignedInteger('brokerage_settlement_id')
                ->defualt(0);

            // 基本时间戳
            $table->timestamps();

            // 买家删除订单标记
            $table->timestamp('buyer_deleted_at')
                ->nullable()
                ->index();

            // 卖家删除订单标记
            $table->timestamp('seller_deleted_at')
                ->nullable()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
