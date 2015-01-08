<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterpriseTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 企业信息表
        Schema::create('enterprise', function (Blueprint $table)
        {
            // 企业ID
            $table->increments('id');

            // 企业域名
            $table->string('domain')->unique();

            // 企业名称
            $table->string('name');

            // 企业法人
            $table->string('legal')->default('');

            // 企业logo
            $table->unsignedInteger('logo_id', false);

            // 企业联系人
            $table->string('contacts')->default('');

            // 企业联系电话
            $table->string('phone')->default('');

            // 省份ID
            $table->unsignedInteger('province_id', false)->default(0);

            // 城市ID
            $table->unsignedInteger('city_id', false)->default(0);

            // 地区ID
            $table->unsignedInteger('district_id', false)->default(0);

            // 具体地址
            $table->string('address')->default('');

            // 经度
            $table->string('longitude')->default('');

            // 纬度
            $table->string('latitude')->default('');

            // 企业描述
            $table->string('description')->default('');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('enterprise');
    }
}
