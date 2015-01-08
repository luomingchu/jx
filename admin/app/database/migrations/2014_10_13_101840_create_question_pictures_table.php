<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionPicturesTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 问题的配图。
        Schema::create('question_pictures', function (Blueprint $table)
        {
            $table->increments('id');

            $table->unsignedInteger('question_id');
            $table->unsignedInteger('picture_id');

            $table->timestamps();

            $table->index([
                'question_id',
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
        Schema::drop('question_pictures');
    }
}
