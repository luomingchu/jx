<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 问题表。
        Schema::create('questions', function (Blueprint $table)
        {
            // 问题ID。
            $table->increments('id');

            // 发布问题的用户。
            $table->unsignedInteger('member_id')->default(0);

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 问题标题
            $table->string('title', 500)->default('');

            // 奖励的值币数
            $table->integer('reward')->default(0);

            // 描述。
            $table->text('content')->default('');

            // 问题类型
            $table->enum('kind', [
                Question::KIND_QUESTION,
                Question::KIND_RESOURCE,
                Question::KIND_PRATTLE
            ])->default(Question::KIND_QUESTION);

            // 是否已关闭。
            $table->enum('close', [
                Question::CLOSE_NO,
                Question::CLOSE_YES
            ])->default(Question::CLOSE_NO);

            // 回答数。
            $table->integer('answer_count')->default(0);

            // 被赞的数目。
            $table->unsignedInteger('like_count')->default(0);

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
        Schema::drop('questions');
    }
}
