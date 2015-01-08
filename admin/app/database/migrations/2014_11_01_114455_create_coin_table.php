<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 指币变更记录。
        Schema::create('coin', function (Blueprint $table)
        {
            // 日志ID。
            $table->increments('id');

            // 发生变更的用户。
            $table->unsignedInteger('member_id')
                ->index();

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 变更金额。
            $table->integer('amount')
                ->default(0);

            // 原因
            $table->string('key');

            // 类型
            $table->enum('type', [
                Coin::TYPE_INCOME,
                Coin::TYPE_EXPENSE
            ])
                ->index();

            // 描述
            $table->string('remark', 255);

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
        Schema::drop('coin');
    }
}
