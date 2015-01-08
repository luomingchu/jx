<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireIssueTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //问卷问题表
        Schema::create('questionnaire_issue', function (Blueprint $table)
        {
            $table->increments('id');

            // 所属测试
            $table->unsignedInteger('questionnaire_id')->default(0);

            // 问题内容
            $table->string('content', 500)->default('');

            // 总参与人
            $table->unsignedInteger('join_count')->default(0);

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
        Schema::drop('questionnaire_issue');
    }
}
