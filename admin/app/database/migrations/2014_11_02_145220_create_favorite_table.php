<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 多态收藏。
        Schema::create('favorites', function (Blueprint $table)
        {
            $table->increments('id');

            // 收藏的用户ID
            $table->unsignedInteger('member_id')
                ->default(0);

            // 收藏模型ID
            $table->unsignedInteger('favorites_id')
                ->default(0);

            // 收藏模型
            $table->string('favorites_type')
                ->default('');

            // 收藏商品时，指定该商品的所属指店
            $table->unsignedInteger('vstore_id')
                ->default(0);

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
        Schema::drop('favorites');
    }
}
