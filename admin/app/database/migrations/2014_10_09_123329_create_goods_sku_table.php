<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsSkuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 商品规格库存表
        Schema::create('goods_sku', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属商品ID
            $table->unsignedInteger('goods_id')->index()->default(0);

            // 商品sku_key
            $table->string('sku_key')->index()->default('');

            // 商品sku_index
            $table->string('sku_index')->index()->default('');

            // 库存数
            $table->unsignedInteger('stock')->default(0);

            // 价格
            $table->decimal('price')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_sku');
	}

}
