<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistrictTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 县区表
        Schema::create('district', function (Blueprint $table)
        {
            // 县区ID
            $table->increments('id');

            // 所属城市ID
            $table->integer('city_id')
                ->unsigned()
                ->index();

            // 县区名
            $table->string('name', 30)
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('district');
    }
}
