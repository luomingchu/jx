<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertiseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        // 广告。
        Schema::create('advertises', function (Blueprint $table)
        {
            // 广告ID。
            $table->increments('id');

            // 所在广告位ID。
            $table->unsignedInteger('space_id')->index();

            // 广告标题。
            $table->string('title')->default('');

            // 广告类型
            $table->enum('kind', [Advertise::KIND_CUSTOM, Advertise::KIND_GOODS])->default(Advertise::KIND_CUSTOM);

            // 链接。
            $table->string('url')->default('');

            // 图片。
            $table->unsignedInteger('picture_id')->default(0);

            // 广告内容
            $table->text('content')->default('');

            // 其它文字。
            $table->string('additional_content')->default('');

            // 状态
            $table->enum('status', [Advertise::STATUS_OPEN, Advertise::STATUS_CLOSE])->default(Advertise::STATUS_OPEN);

            // 推广商品ID
            $table->string('popularize_goods')->default('');

            // 推广商品模板图片文件
            $table->unsignedInteger('template_picture_id')->default(0);

            // 模板文件名
            $table->string('template_name')->default('');

            // 备注。不在前台显示。
            $table->string('remark')->default('');

            // 排序。
            $table->integer('sort')->default(100);

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
        Schema::drop('advertises');
	}

}
