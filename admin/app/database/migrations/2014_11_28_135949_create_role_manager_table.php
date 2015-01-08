<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleManagerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // 角色管理员关联表
        Schema::create('role_manager', function(Blueprint $table)
        {
            // 所属角色
            $table->unsignedInteger('role_id')->index()->default(0);

            // 所属管理员
            $table->unsignedInteger('manager_id')->index()->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('role_manager');
	}

}
