<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesGoodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    // 活动内商品。
		Schema::create('activities_goods', function(Blueprint $table)
		{
			$table->increments('id');

            // 所属活动
			$table->unsignedInteger('activity_id')->index()->default(0);

            // 活动商品
			$table->unsignedInteger('goods_id')->index()->default(0);

            // 活动商品折扣
            $table->decimal('discount', 3, 2)->default(0);

            // 商品限购
            $table->integer('quota')->default(0);

            // 最高指币抵用率
            $table->integer('coin_max_use_ratio')->default(0);

            // 活动商品折后价
            $table->decimal('discount_price', 8, 2)->default(0);

            // 订金
            $table->decimal('deposit', 8, 2)->default(0);

            // 佣金比率
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
		Schema::drop('activities_goods');
	}

}
