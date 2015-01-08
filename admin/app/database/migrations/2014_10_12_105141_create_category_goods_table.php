<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryGoodsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品分类多对多表
        Schema::create('category_goods', function (Blueprint $table)
        {
            $table->increments('id');

            // 总店商品ID
            $table->unsignedInteger('goods_id', false)
                ->index();

            // 商品分类ID
            $table->unsignedInteger('goods_category_id', false)
                ->index();

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
        Schema::drop('category_goods');
    }
}
