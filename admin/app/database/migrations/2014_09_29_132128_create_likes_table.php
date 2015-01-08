<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 赞日志记录多态表。
        Schema::create('likes', function (Blueprint $table)
        {
            $table->increments('id');

            // 赞的用户ID
            $table->unsignedInteger('member_id')->index()->default(0);

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 多态键
            $table->morphs('target');

            $table->unique([
                'member_id',
                'target_id',
                'target_type'
            ]);

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
        Schema::drop('likes');
    }
}
