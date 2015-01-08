<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInnerPurchaseTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 内购活动。
        Schema::create('inner_purchase', function (Blueprint $table)
        {
            $table->increments('id');

            //指币抵用最高比例
            $table->float('coin_max_use_ratio')->defalut(10);

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
        Schema::drop('inner_purchase');
    }
}
