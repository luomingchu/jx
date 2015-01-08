<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 企业公告表
        Schema::create('notices', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 公告标题
            $table->string('title')->default('');

            // 公告内容
            $table->text('content')->default('');

            // 公开状态
            $table->enum('status', [Notice::STATUS_OPEN, Notice::STATUS_CLOSE])->default(Notice::STATUS_OPEN);

            // 排序顺序
            $table->integer('sort_order')->default(255);

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
        Schema::drop('notices');
	}

}
