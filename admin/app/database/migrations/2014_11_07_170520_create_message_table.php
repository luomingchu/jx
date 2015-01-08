<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 消息总表
        Schema::create('messages', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 接受消息的人
            $table->unsignedInteger('member_id')->index()->default(0);

            // 接受消息用户类型
            $table->string('member_type')->index()->default('');

            // 读取状态
            $table->enum('read', [Message::READ_NO, Message::READ_YES])->default(Message::READ_NO);

            // 消息类型
            $table->enum('type', [Message::TYPE_STORE, Message::TYPE_COMMUNITY, Message::TYPE_SYSTEM]);

            // 消息具体分类
            $table->enum('specific', [Message::SPECIFIC_ACCEPT, Message::SPECIFIC_ANSWER, Message::SPECIFIC_FOLLOW, Message::SPECIFIC_SPONSOR, Message::SPECIFIC_ORDER, Message::SPECIFIC_GENERAL, Message::SPECIFIC_COMMON, Message::SPECIFIC_REFUND]);

            // 消息体。
            $table->string('body_id');
            $table->string('body_type');
            $table->index([
                'body_id',
                'body_type'
            ]);

            // 消息说明
            $table->string('description', 3000)->default('');

            // 是否已提醒
            $table->enum('alerted', [Message::ALERT_NO, Message::ALERT_YES])->default(Message::ALERT_NO);

            $table->timestamps();
            $table->softDeletes();
            $table->index('deleted_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('messages');
	}

}
