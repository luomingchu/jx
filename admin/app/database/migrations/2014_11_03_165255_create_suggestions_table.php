<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 对软件提出的意见建议表
        Schema::create('suggestions', function (Blueprint $table)
        {
            $table->increments('id');

            // 提出意见者。
            $table->unsignedInteger('member_id');

            // 内容。
            $table->text('content');

            // 提交者的IP
            $table->string('ip')->default('');

            // 备注[用于管理员对此问题的回复或备注]，用户只提交，看不到所提的意见的入口
            $table->text('remark')->defaut('');

            // 备注时间
            $table->dateTime('remark_time');

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
        Schema::drop('suggestions');
    }
}
