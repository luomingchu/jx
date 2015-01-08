<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseConfigsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 企业设置表
        Schema::create('enterprise_configs', function (Blueprint $table)
        {
            // 自增主键ID
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 后台站头logo图片
            $table->char('admin_logo_hash', 32);

            // 下载页面的Logo
            $table->char('admin_logo_hash2', 32);

            // 登录页面logo
            $table->char('login_logo_hash', 32);

            // 登录页面右边大图
            $table->char('login_big_hash', 32);

            // 企业信息页面logo图片
            $table->char('info_logo_hash', 32)->default('');

            // 登录界面颜色
            $table->string('login_color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enterprise_configs');
    }
}
