<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 活动。
        Schema::create('activities', function (Blueprint $table)
        {
            // 活动ID。
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 活动标题（名称）。
            $table->string('title')->default('');

            // 活动图片
            $table->unsignedInteger('picture_id')->default(0);

            // 开始时间。
            $table->dateTime('start_datetime');

            // 结束时间。
            $table->dateTime('end_datetime');

            // 当前状态。
            $table->enum('status', [
                Activity::STATUS_OPEN,
                Activity::STATUS_CLOSE
            ])->default(Activity::STATUS_CLOSE);

            // 活动额外信息体。
            $table->unsignedInteger('body_id')->nullable();
            $table->string('body_type')->default('');


            // 活动说明。
            $table->string('introduction', 5000)->default('');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
    public function down()
    {
        Schema::drop('activities');
    }
}
