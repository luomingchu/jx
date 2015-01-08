<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSharesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 多态分享
        Schema::create('shares', function (Blueprint $table)
        {
            $table->increments('id');

            // 分享的用户ID
            $table->unsignedInteger('member_id')
                ->default(0);

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 分享模型ID
            $table->unsignedInteger('item_id')
                ->default(0);

            // 分享模型
            $table->string('item_type')
                ->default('');

            // 分享商品时，指定该商品的所属指店
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
        Schema::drop('shares');
    }
}
