<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundLogTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 退款、退货申请表
        Schema::create('refund_log', function (Blueprint $table)
        {
            $table->increments('id');

            // 所属申请单ID
            $table->char('refund_id', 18)
                ->index()
                ->default('');

            // 对应用户
            $table->morphs('user');

            // 标题
            $table->string('title')
                ->default('');

            // 详情
            $table->string('content', 500)
                ->default('');

            // 订单原始状态
            $table->enum('original_status', [
                RefundLog::STATUS_APPLY,
                RefundLog::STATUS_WAIT_STORE_AGREE,
                RefundLog::STATUS_STORE_REFUSE_BUYER,
                RefundLog::STATUS_WAIT_BUYER_RETURN_GOODS,
                RefundLog::STATUS_WAIT_STORE_CONFIRM_GOODS,
                RefundLog::STATUS_WAIT_ENTERPRISE_REPAYMENT,
                RefundLog::STATUS_SUCCESS
            ]);

            // 订单当前状态
            $table->enum('current_status', [
                RefundLog::STATUS_APPLY,
                RefundLog::STATUS_WAIT_STORE_AGREE,
                RefundLog::STATUS_STORE_REFUSE_BUYER,
                RefundLog::STATUS_WAIT_BUYER_RETURN_GOODS,
                RefundLog::STATUS_WAIT_STORE_CONFIRM_GOODS,
                RefundLog::STATUS_WAIT_ENTERPRISE_REPAYMENT,
                RefundLog::STATUS_SUCCESS
            ]);

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
        Schema::drop('refund_log');
    }
}
