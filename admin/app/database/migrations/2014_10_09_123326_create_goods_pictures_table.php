<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsPicturesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品图片表
        Schema::create('goods_pictures', function (Blueprint $table)
        {
            // 商品图片表ID
            $table->increments('id');

            // 总店商品ID
            $table->unsignedInteger('goods_id')->default(0);

            // 商品图片ID
            $table->unsignedInteger('picture_id', false)->default(0);

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
        Schema::drop('goods_pictures');
    }
}
