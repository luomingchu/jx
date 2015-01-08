<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderGoodsTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 订单内商品
        Schema::create('order_goods', function (Blueprint $table)
        {
            $table->increments('id');

            // 所属订单
            $table->char('order_id', 18)->index();

            // 商品ID
            $table->unsignedInteger('goods_id')->index();

            // 商品名称
            $table->string('goods_name')->default('');

            // 商品的规格
            $table->string('goods_sku')->default('');

            // 商品价格
            $table->decimal('price');

            // 商量数量
            $table->integer('quantity');

            // 商品佣金比率
            $table->decimal('brokerage_ratio', 5, 2)->default(0);

            // 指店等级佣金比率
            $table->decimal('level_brokerage_ratio', 5, 2)->default(0);

            // 买家评价
            $table->unsignedInteger('comment_id');

            // 所属企业活动
            $table->unsignedInteger('activity_id')->index()->default(0);

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
        Schema::drop('order_goods');
    }
}
