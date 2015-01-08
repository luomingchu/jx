<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePushBindTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // 用户在百度云推送的绑定的参数表
        Schema::create('push_bind', function (Blueprint $table)
        {
            $table->increments('id');

            // 用户ID
            $table->unsignedInteger('user_id')->index()->default(0);

            // 用户类型
            $table->string('user_type')->default('');

            // 百度用户标识
            $table->string('push_user_id', 256)->index()->default('');

            // 百度channelID
            $table->string('channel_id')->default('');

            // 用户设备信息
            $table->string('device_info')->default('');

            // 用户绑定的分组
            $table->string('tag_list')->default('');

            // 百度推送的类别
            $table->string('kind')->default('');

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
        Schema::drop('push_bind');
	}

}
