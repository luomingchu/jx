<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 商品表
        Schema::create('goods', function (Blueprint $table)
        {
            // 商品ID
            $table->increments('id');

            // 所属企业id
            $table->unsignedInteger('enterprise_id')
                ->index()
                ->default(0);

            // 商品型号
            $table->string('number');

            // 商品名称
            $table->string('name', 120);

            // 商品类别
            $table->unsignedInteger('goods_type_id')
                ->default(0);

            // 商品库存
            $table->unsignedInteger('stock', false)
                ->default(0);

            // 商品详情
            $table->text('description')
                ->default('');

            // 商品参数
            $table->text('parameter')
                ->defalut('');

            // 市场价
            $table->decimal('market_price',10,2)
                ->default(0);

            // 门市价
            $table->decimal('price',10,2)
                ->default(0);

            // 佣金比率
            $table->decimal('brokerage_ratio', 5, 2)->default(0);

            // 佣金最后修改时间
            $table->timestamp('brokerage_ratio_updated_time')->nullable();

            // 商品的评论数
            $table->unsignedInteger('comment_count')
                ->default(0);

            // 商品的收藏数
            $table->unsignedInteger('favorite_count')
                ->default(0);

            // 商品状态
            $table->enum('status', array(
                Goods::STATUS_OPEN,
                Goods::STATUS_CLOSE
            ))
                ->default(Goods::STATUS_OPEN)
                ->index();

            // 已交易[卖出]数量,或者已换购数量
            $table->unsignedInteger('trade_quantity');

            // 排序
            $table->unsignedInteger('sort', false)
                ->default(255);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('goods');
    }
}
