<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 市级表
        Schema::create('city', function (Blueprint $table)
        {
            // 城市ID
            $table->increments('id');

            // 所属省份ID
            $table->unsignedInteger('province_id')
                ->index();

            // 排序
            $table->integer('sort')
                ->index();

            // 城市名
            $table->string('name', 50)
                ->unique();

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
        Schema::drop('city');
    }
}
