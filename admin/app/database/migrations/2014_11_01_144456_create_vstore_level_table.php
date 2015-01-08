<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVstoreLevelTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 指店等级记录表
        Schema::create('vstore_level', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id');

            // 等级
            $table->decimal('level', 2, 1)->default(0);

            // 成交量
            $table->integer('trade_count')->default(0);

            // 成交额
            $table->decimal('turnover', 12, 2)->default(0);

            // 享受佣金比
            $table->decimal('brokerage_ratio', 5, 2)->default(0);

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
        Schema::drop('vstore_level');
	}

}
