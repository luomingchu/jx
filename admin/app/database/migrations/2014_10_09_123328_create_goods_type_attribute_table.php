<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTypeAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 商品类别属性表
        Schema::create('goods_type_attributes', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属商品类别
            $table->unsignedInteger('goods_type_id')->index()->default(0);

            // 商品类别属性名称
            $table->string('name')->default('');

            // 属性排序
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods_type_attributes');
    }

}
