<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAddressTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 订单收货地址表
        Schema::create('order_address', function (Blueprint $table)
        {
            $table->increments('id');

            // 订单ID
            $table->char('order_id', 18)->index();

            // 收件人姓名
            $table->string('consignee');

            // 手机号
            $table->string('mobile');

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

            // 发货快递公司名
            $table->string('express_name')->default('');

            // 发货快递单号
            $table->string('express_number')->default('');

            // 发货时间
            $table->dateTime('express_datetime')->nullable();

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
        Schema::drop('order_address');
    }
}
