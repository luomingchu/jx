<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnaireTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 问卷调查
        Schema::create('questionnaire', function (Blueprint $table)
        {
            // 主键ID
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 投放测试标题
            $table->string('name')
                ->default('');

            // 问题数
            $table->integer('issue_count')
                ->default(0);

            // 查看人数
            $table->integer('view_count')
                ->default(0);

            // 参与人数
            $table->integer('join_count')
                ->default(0);

            // 图片
            $table->string('picture_hash')
                ->default('');

            // 活动开始时间
            $table->timestamp('start_time')
                ->nullable();

            // 活动结束时间
            $table->timestamp('end_time')
                ->nullable();

            // 产品参数
            $table->string('description')
                ->default('');

            // 状态
            $table->enum('status', [
                Questionnaire::STATUS_OPEN,
                Questionnaire::STATUS_CLOSE,
                Questionnaire::STATUS_UNOPENED
            ])
                ->default(Questionnaire::STATUS_OPEN);

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
        Schema::drop('questionnaire');
    }
}
