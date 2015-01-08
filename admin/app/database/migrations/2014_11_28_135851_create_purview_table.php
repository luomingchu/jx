<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurviewTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 权限表
        Schema::create('purviews', function(Blueprint $table)
        {
            $table->increments('id');

            // 权限名称
            $table->string('name')->default('');

            // 权限标识符
            $table->string('purview_key')->default('');

            // 权限所属父级
            $table->unsignedInteger('parent_id')->index()->default(0);

            // 权限上下级路径表
            $table->string('parent_path', 500)->default('');

            // 权限所属控制器
            $table->string('controller')->index()->default('');

            // 权限所属控制器方法
            $table->string('action')->index()->default('');

            // 权限规则附加条件，如：goods_type=Inner等
            $table->string('condition', 300)->default('');

            // 类型
            $table->enum('type', [Purview::TYPE_MENU, Purview::TYPE_ACTION])->default(Purview::TYPE_ACTION);

            // 权限状态
            $table->enum('status', [Purview::STATUS_VALID, Purview::STATUS_INVALID])->default(Purview::STATUS_VALID);

            // 排序号
            $table->integer('sort_order')->default(100);

            // 权限描述
            $table->string('remark', 500)->default('');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('purviews');
	}

}
