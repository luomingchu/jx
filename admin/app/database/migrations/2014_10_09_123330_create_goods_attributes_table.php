<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 商品销售属性表
        Schema::create('goods_attributes', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属商品
            $table->unsignedInteger('goods_id')->index()->default(0);

            // 类别属性ID
            $table->unsignedInteger('goods_type_attribute_id')->index()->default(0);

            // 属性值
            $table->string('name')->default('');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('goods_attributes');
	}

}
