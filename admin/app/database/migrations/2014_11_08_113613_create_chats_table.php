<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 聊天记录表
        Schema::create('chats', function (Blueprint $table)
        {
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 发送人
            $table->unsignedInteger('sender')->default(0);

            // 接收人
            $table->unsignedInteger('receiver')->default(0);

            // 消息类型
            $table->enum('kind', [
                Chat::KIND_TEXT,
                Chat::KIND_PICTURE,
                Chat::KIND_AUDIO
            ])->default(Chat::KIND_TEXT);

            // 消息内容
            $table->string('content')->default('');

            // 图片
            $table->unsignedInteger('picture_id')->default(0);

            // 音频
            $table->unsignedInteger('audio_id')->default(0);

            // 状态，是否已读
            $table->enum('status', [
                Chat::STATUS_READ,
                Chat::STATUS_UNREAD
            ])->default(Chat::STATUS_UNREAD);

            // 发布的时间
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
        Schema::drop('chats');
    }
}
