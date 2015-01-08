<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // 会员等级设置表
        Schema::create('level', function(Blueprint $table)
        {
            $table->increments('id');

            // 等级
            $table->integer('level')->default(1);

            // 所属企业ID
            $table->unsignedInteger('enterprise_id');

            // 成交量
            $table->integer('trade_count')->default(0);

            // 成交额
            $table->decimal('turnover', 12, 2)->default(0);

            // 奖励指币
            $table->integer('coin')->default(0);

            // 奖励内购额
            $table->decimal('insource', 10, 2)->default(0);

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
        Schema::drop('level');
	}

}
