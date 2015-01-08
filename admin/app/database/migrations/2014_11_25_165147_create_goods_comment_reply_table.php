<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCommentReplyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 商品评论回复表
        Schema::create('goods_comment_reply', function(Blueprint $table)
        {
            $table->increments('id');

            // 回复的评论ID
            $table->unsignedInteger('goods_comment_id')->index()->default(0);

            // 回复企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 回复内容
            $table->string('content', 2000)->default('');

            // 回复时间
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
        Schema::drop('goods_comment_reply');
	}

}
