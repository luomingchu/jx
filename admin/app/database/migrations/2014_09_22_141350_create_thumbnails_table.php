<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThumbnailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 图片缩略图。
        Schema::create('thumbnails', function (Blueprint $table)
        {
            $table->increments('id');

            // 图片。
            $table->unsignedInteger('file_id');

            // 缩略图。
            $table->char('storage_hash', 32);

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
        Schema::drop('thumbnails');
    }
}
