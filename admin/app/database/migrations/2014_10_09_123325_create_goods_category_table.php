<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCategoryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品分类表
        Schema::create('goods_category', function (Blueprint $table)
        {
            // 商品分类ID
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id');

            // 分类名称
            $table->string('name', 128);

            // 父路径
            $table->string('parent_path');

            // 排序
            $table->unsignedInteger('sort', false)
                ->default(255);

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
        Schema::drop('goods_category');
    }
}
