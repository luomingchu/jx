<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 任务表
        Schema::create('tasks', function (Blueprint $table)
        {
            // 主键key
            $table->string('key')
                ->primary();

            // 周期【一次性-每个人指友一次，每天-每天每个人多少次，不限周期-总共奖励多少次】
            $table->enum('cycle', array(
                Task::CYCLE_ONCE,
                Task::CYCLE_EVERYDAY,
                Task::CYCLE_NOCYCLE
            ))
                ->default(Task::CYCLE_ONCE);

            // 每次奖励的金币
            $table->unsignedInteger('reward_coin')
                ->default(0);

            // 每次奖励的内购额
            $table->float('reward_insource')
                ->default(0);

            // 奖励次数，周期为一次性时用不到这个字段
            $table->unsignedInteger('reward_times')
                ->default(0);

            // 任务备注
            $table->string('remark')
                ->default('');

            // 成功购买商品，领取的有效时长
            // $table->string('valid_time')->default("#72D572");

            // 是否启用
            $table->enum('status', array(
                Task::STATUS_OPEN,
                Task::STATUS_CLOSE
            ))
                ->default(Task::STATUS_CLOSE);

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
        Schema::drop('tasks');
    }
}
