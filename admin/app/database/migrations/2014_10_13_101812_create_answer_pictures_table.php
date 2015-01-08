<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerPicturesTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 回答的配图。
        Schema::create('answer_pictures', function (Blueprint $table)
        {
            $table->increments('id');

            $table->unsignedInteger('answer_id');
            $table->unsignedInteger('picture_id');

            $table->timestamps();

            $table->index([
                'answer_id',
                'picture_id'
            ]);
        });
    }

    /**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
    public function down()
    {
        Schema::drop('answer_pictures');
    }
}
