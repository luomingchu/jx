<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuggestTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 买家对企业提出意见
        Schema::create('suggest', function (Blueprint $table)
        {
            $table->increments('id');

            // 提出意见者。
            $table->unsignedInteger('member_id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

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
        Schema::drop('suggest');
    }
}
