<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 订单操作记录表
        Schema::create('order_logs', function (Blueprint $table)
        {
            $table->increments('id');

            // 订单ID
            $table->char('order_id', 18)
                ->index();

            // 日志内容
            $table->string('content');

            // 订单原始状态 Init为第一条记录的初始状态
            $table->enum('original_status', [
                Order::STATUS_PENDING_PAYMENT,
                Order::STATUS_CANCEL,
                Order::STATUS_PREPARING_FOR_SHIPMENT,
                Order::STATUS_SHIPPED,
                Order::STATUS_PROCESSING,
                Order::STATUS_READY_FOR_PICKUP,
                Order::STATUS_FINISH,
                Order::STATUS_ERROR,
                Order::STATUS_INIT,
            ])
                ->default(Order::STATUS_INIT);

            // 订单当前状态
            $table->enum('current_status', [
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
        Schema::drop('order_logs');
    }
}
