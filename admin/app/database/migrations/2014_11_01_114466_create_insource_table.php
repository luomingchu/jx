<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsourceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 内购额变更记录。
        Schema::create('insource', function (Blueprint $table)
        {
            // 日志ID。
            $table->increments('id');

            // 发生变更的用户。
            $table->unsignedInteger('member_id')
                ->index();

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 变更金额。
            $table->decimal('amount', 10, 2);

            // 原因
            $table->string('key');

            // 类型
            $table->enum('type', [
                Insource::TYPE_INCOME,
                Insource::TYPE_EXPENSE
            ])->index();

            // 备注
            $table->string('remark')->default('');

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
        Schema::drop('insource');
    }
}
