<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCommentTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 商品评价表
        Schema::create('goods_comments', function (Blueprint $table)
        {
            $table->increments('id');

            // 评价的用户
            $table->unsignedInteger('member_id')->index();

            // 是否匿名评价
            $table->enum('anonymous', [
                GoodsComment::ANONYMOUS_ENABLE,
                GoodsComment::ANONYMOUS_UNABLE
            ])->default(GoodsComment::ANONYMOUS_UNABLE);

            // 评价的订单商品
            $table->unsignedInteger('order_goods_id')->index()->default(0);

            // 评价的商品
            $table->unsignedInteger('goods_id')->index()->default(0);

            // 评价分数1-5星
            $table->integer('evaluation')->default(5);

            // 评论内容，针对订单下每个商品
            $table->string('content')->default('');

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
        Schema::drop('goods_comments');
    }
}
