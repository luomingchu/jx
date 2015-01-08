<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 银行表
        Schema::create('banks', function (Blueprint $table)
        {
            // 主键ID
            $table->increments('id');

            // 银行名称
            $table->string('name', 32)->unique();

            // 银行logo
            $table->string('logo_hash')->default('');

            // 银行热线电话
            $table->string('hotline')->default('');

            // 银行简介
            $table->string('remark')->default('');

            // 排序
            $table->integer('sort')->default(100);

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
        Schema::drop('banks');
    }
}
