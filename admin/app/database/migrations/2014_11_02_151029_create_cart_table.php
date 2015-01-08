<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 购物车
        Schema::create('carts', function(Blueprint $table)
        {
            // 购物车ID
            $table->increments('id');

            // 买家用户ID
            $table->unsignedInteger('member_id')->index()->default(0);

            // 所属指店ID
            $table->unsignedInteger('vstore_id')->index()->default(0);

            // 所属商品ID
            $table->unsignedInteger('goods_id')->index()->default(0);

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 商品数量
            $table->unsignedInteger('quantity')->default(0);

            // 商品规格
            $table->unsignedInteger('sku_id')->default(0);

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
		Schema::drop('carts');
	}

}
