<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlipayAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 支付宝绑定表
        Schema::create('alipay_accounts', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属用户ID
            $table->unsignedInteger('member_id')->index()->default(0);

            // 支付宝账号
            $table->string('alipay_account')->default('');

            // 支付宝用户名
            $table->string('alipay_username')->default('');

            // 默认支付宝账号
            $table->enum('is_default', [
                AlipayAccount::ISDEFAULT,
                AlipayAccount::UNDEFAULT
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
        Schema::drop('alipay_accounts');
	}

}
