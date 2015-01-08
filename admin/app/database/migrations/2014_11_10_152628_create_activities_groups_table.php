<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 活动和门店区域关联表
        Schema::create('activities_groups', function(Blueprint $table)
        {
            $table->increments('id');

            // 活动ID
            $table->unsignedInteger('activity_id')->index()->default(0);

            // 区域ID
            $table->unsignedInteger('group_id')->index()->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('activities_groups');
	}

}
