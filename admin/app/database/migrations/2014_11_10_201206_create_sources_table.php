<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 纸币来源表
        Schema::create('sources', function (Blueprint $table)
        {
            // 主键key
            $table->string('key')->primary();

            // 来源名称
            $table->string('name');

            // 备注
            $table->string('remark')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sources');
    }
}
