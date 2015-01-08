<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertiseSpaceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // 广告位。
        Schema::create('advertise_spaces', function (Blueprint $table)
        {
            // 广告位ID。
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 广告位名称。
            $table->string('name')->default('');

            // 广告位key
            $table->string('key_code')->index()->default('');

            // 宽度。
            $table->integer('width')->default(0);

            // 高度。
            $table->integer('height')->default(0);

            // 显示数量。零为全部显示。
            $table->integer('limit')->default(0);

            // 广告位备注。不在前台显示。
            $table->string('remark')->default('');

            // 广告位模版代码。
            $table->text('template');

            $table->timestamps();
            $table->softDeletes();
            $table->index('deleted_at');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('advertise_spaces');
	}

}
