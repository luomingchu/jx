<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankcardTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户银行卡表
        Schema::create('bankcards', function (Blueprint $table)
        {
            // 主键ID
            $table->increments('id');

            // 用户ID
            $table->unsignedInteger('member_id', false);

            // 银行ID
            $table->unsignedInteger('bank_id', false);

            // 银行卡号
            $table->string('number');

            // 银行预留手机号
            $table->string('mobile');

            // 真实姓名
            $table->string('real_name', 32);

            // 开户行
            $table->string('open_account_bank');

            // 是否默认
            $table->enum('is_default', [
                Bankcard::ISDEFAULT,
                Bankcard::UNDEFAULT
            ]);

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
        Schema::drop('bankcards');
    }
}
