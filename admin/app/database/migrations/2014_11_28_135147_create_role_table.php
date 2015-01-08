<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // 角色表
        Schema::create('roles', function(Blueprint $table)
        {
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 角色标识符
            $table->string('role_key')->default('');

            // 角色名称
            $table->string('name')->default('');

            // 角色描述
            $table->string('remark', 2000)->default('');

            // 状态
            $table->enum('status', [Role::STATUS_VALID, Role::STATUS_INVALID])->default(Role::STATUS_VALID);

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
        Schema::drop('roles');
	}

}
