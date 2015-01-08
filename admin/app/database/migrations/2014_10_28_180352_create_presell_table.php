<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresellTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 预售活动。
        Schema::create('presell', function (Blueprint $table) {
            $table->increments('id');

            // 预售结款开始时间
            $table->dateTime('start_settle_datetime');

            // 预售结款结束时间
            $table->dateTime('end_settle_datetime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('presell');
    }

}
