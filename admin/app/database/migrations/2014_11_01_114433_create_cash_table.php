<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 现金变更记录。
        Schema::create('cash', function (Blueprint $table)
        {
            // 日志ID。
            $table->increments('id');

            // 发生变更的用户。
            $table->unsignedInteger('member_id')->index();

            // 变更金额。
            $table->decimal('amount', 10, 2);

            // 原因
            $table->string('reason');

            // 类型
            $table->enum('type', [
                Cash::TYPE_INCOME,
                Cash::TYPE_EXPENSE
            ])->index();

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
        Schema::drop('cash');
    }
}
