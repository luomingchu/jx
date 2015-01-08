<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundPicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 退款/货申请单图片表
        Schema::create('refund_pictures', function(Blueprint $table)
        {
            // 退款、退货申请单号
            $table->char('refund_id', 18)->index()->default('');

            // 图片ID
            $table->unsignedInteger('picture_id')->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('refund_pictures');
	}

}
