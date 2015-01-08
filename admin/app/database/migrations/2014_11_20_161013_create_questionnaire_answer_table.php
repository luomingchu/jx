<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireAnswerTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //问卷回答表
        Schema::create('questionnaire_answer', function (Blueprint $table)
        {
            $table->increments('id');

            // 所属问题
            $table->unsignedInteger('questionnaire_issue_id')->default(0);

            // 选项内容
            $table->string('content')->default('');

            // 选择人数
            $table->unsignedInteger('choose_count')->default(0);

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
        Schema::drop('questionnaire_answer');
    }
}
