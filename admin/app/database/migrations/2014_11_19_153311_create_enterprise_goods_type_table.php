<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseGoodsTypeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 企业定制的商品类目表
        Schema::create('enterprise_goods_type', function (Blueprint $table)
        {
            // 主键ID
            $table->increments('id');

            // 商品类目ID
            $table->unsignedInteger('goods_type_id', false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enterprise_goods_type');
    }
}
