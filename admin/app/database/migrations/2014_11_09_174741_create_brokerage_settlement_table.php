<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrokerageSettlementTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 佣金结算表
        Schema::create('brokerage_settlement', function (Blueprint $table)
        {
            $table->increments('id');

            // 结算人,企业后台登录者ID
            $table->unsignedInteger('reckoner');

            // 结算备注
            $table->text('remark')
                ->default('');

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
        Schema::drop('brokerage_settlement');
    }
}
