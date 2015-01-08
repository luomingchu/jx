<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseSystemParametersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 企业参数设置表
        Schema::create('enterprise_system_parameters', function (Blueprint $table)
        {
            // 自增id
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // key标识
            $table->string('key');

            // 参数名
            $table->string('name');

            // 设置的值
            $table->string('keyvalue');

            // 备注
            $table->string('remark')
                ->nullable();

            //是否显示
            $table->enum('is_show',[
                SystemParameters::IS_SHOW_YES,
                SystemParameters::IS_SHOW_NO
            ])->default(SystemParameters::IS_SHOW_YES);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enterprise_system_parameters');
    }
}
