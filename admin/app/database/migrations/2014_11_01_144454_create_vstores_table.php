<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVstoresTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 指店表
        Schema::create('vstores', function (Blueprint $table)
        {
            // 指店ID
            $table->increments('id');

            // 所属用户ID
            $table->unsignedInteger('member_id')->index();

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index();

            // 指店名称
            $table->string('name');

            // 指店状态
            $table->enum('status', [
                Vstore::STATUS_OPEN,
                Vstore::STATUS_CLOSE,
                Vstore::STATUS_ENTERPRISE_AUDITING,
                Vstore::STATUS_ENTERPRISE_AUDITERROR,
                Vstore::STATUS_ENTERPRISE_AUDITED,
                Vstore::STATUS_MEMBER_GETED
            ])
                ->default(Vstore::STATUS_ENTERPRISE_AUDITING)
                ->index();

            // 指店评分分数
            $table->unsignedInteger('score');

            // 指店等级
            $table->decimal('level', 2, 1)->default(0);

            // 企业审核时间
            $table->timestamp('enterprise_audit_time');

            // 企业不通过理由（记录最新的不通过理由，历史记录写入 vstore_operation_log）
            $table->string('enterprise_reject_reason')->default('');

            // 关店时间,由企业关店
            $table->timestamp('enterprise_close_time');

            // 关店理由原因,由企业关店（记录最新的关店理由，历史记录写入 vstore_operation_log）
            $table->string('enterprise_close_reason')->default('');

            // 总成交订单数
            $table->integer('trade_order');

            // 总成交商品数（交易成功）
            $table->integer('trade_quantity')->default(0);

            // 总成交额
            $table->decimal('trade_amount')->default(0);

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
        Schema::drop('vstores');
    }
}
