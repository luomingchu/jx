<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 收货地址表
        Schema::create('address', function (Blueprint $table)
        {
            // 收货地址ID
            $table->increments('id');

            // 地址类型
            $table->enum('type', [
                Address::TYPE_RECEIPT,
                Address::TYPE_DELIVER
            ])->default(Address::TYPE_RECEIPT);

            // 用户ID
            $table->unsignedInteger('member_id')->index();

            // 收件人姓名
            $table->string('consignee');

            // 手机号
            $table->string('mobile');

            // 电话号码
            $table->string('phone');

            // 邮编
            $table->string('zipcode');

            // 省份ID
            $table->unsignedInteger('province_id');

            // 市级ID
            $table->unsignedInteger('city_id');

            // 地区ID
            $table->unsignedInteger('district_id');

            // 省市区地址
            $table->string('region_name');

            // 详细地址
            $table->string('address');

            // 是否默认地址
            $table->enum('is_default', [
                Address::ISDEFAULT,
                Address::UNDEFAULT
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
        Schema::drop('address');
    }
}
