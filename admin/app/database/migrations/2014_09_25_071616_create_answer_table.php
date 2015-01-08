<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 问答模块的回答部分。
        Schema::create('answers', function (Blueprint $table)
        {
            // 问题ID。
            $table->increments('id');

            // 所回答的问题。
            $table->unsignedInteger('question_id')
                ->default(0);

            // 发布回答的用户。
            $table->unsignedInteger('member_id')
                ->default(0);

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 被回答的回答ID
            $table->unsignedInteger('be_answered_id')
                ->default(0);

            // 描述。
            $table->text('content')
                ->default('');

            // 被采纳。
            $table->enum('accept', [
                Answer::ACCEPT_NO,
                Answer::ACCEPT_YES
            ])
                ->default(Answer::ACCEPT_NO);

            // 被赞的数目。
            $table->unsignedInteger('like_count')
                ->default(0);

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
        Schema::drop('answers');
    }
}
