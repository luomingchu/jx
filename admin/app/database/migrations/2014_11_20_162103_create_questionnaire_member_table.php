<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireMemberTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 问题用户回答表
        Schema::create('questionnaire_member', function (Blueprint $table)
        {
            $table->increments('id');

            // 用户ID
            $table->unsignedInteger('member_id');

            // 问答ID
            $table->unsignedInteger('questionnaire_id');

            // 回答的问题-答案列表
            $table->string('result', 500)
                ->nullable();

            // 用户的建议
            $table->string('advice', 1000)
                ->nullable();

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
        Schema::drop('questionnaire_member');
    }
}
