<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTypeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品类别表
        Schema::create('goods_type', function (Blueprint $table)
        {
            $table->increments('id');

            // 商品类别名称
            $table->string('name')->default('');

            // 商品类别属性数
            $table->integer('attr_count')->default(0);

            // 状态
            $table->enum('status', [
                GoodsType::STATUS_OPEN,
                GoodsType::STATUS_CLOSE
            ])->default(GoodsType::STATUS_OPEN);

            $table->softDeletes();
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
        Schema::drop('goods_type');
    }
}
