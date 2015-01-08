<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseBankcardTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 企业银行卡表
        Schema::create('enterprise_bankcards', function (Blueprint $table)
        {
            // 主键ID
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 所属银行
            $table->unsignedInteger('bank_id', false);

            // 账户卡号
            $table->string('number');

            // 账户名称
            $table->string('name');

            // 银行分支机构码
            $table->string('branch_code');

            // 银行网点名称
            $table->string('branch_name');

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
        Schema::drop('enterprise_bankcards');
    }
}
