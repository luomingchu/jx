<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceDispenseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 指币、资源分配缓存表
        Schema::create('resource_dispense', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 手机号
            $table->char('mobile', 11)->index()->default('');

            // 指币数
            $table->integer('coin')->default(0);

            // 内购额数
            $table->decimal('insource', 8, 2)->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('resource_dispense');
	}

}
