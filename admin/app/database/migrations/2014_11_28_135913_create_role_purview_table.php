<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePurviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 角色权限关联表
        Schema::create('role_purview', function(Blueprint $table)
        {
            // 所属角色
            $table->unsignedInteger('role_id')->index()->default(0);

            // 所属权限
            $table->unsignedInteger('purview_id')->index()->default(0);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('role_purview');
	}

}
