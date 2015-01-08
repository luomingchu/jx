<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinceTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 省份表
        Schema::create('province', function (Blueprint $table)
        {
            // 省份ID
            $table->increments('id');

            // 排序
            $table->integer('sort')->index();

            // 省份名
            $table->string('name', 50)->unique();

            // 备注
            $table->string('remark', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('province');
    }
}
