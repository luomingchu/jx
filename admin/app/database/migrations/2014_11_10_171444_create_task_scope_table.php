<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskScopeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 成功购买商品的任务奖励范围，范围为频道表
        Schema::create('task_scope', function (Blueprint $table)
        {
            $table->increments('id');

            // 任务ID，此任务必须是为成功购买商品的任务
            $table->string('task_key');

            // 商品频道ID
            $table->unsignedInteger('goods_channel_id', false);

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
        Schema::drop('task_scope');
    }
}
