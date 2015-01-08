<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户文件。
        Schema::create('user_files', function (Blueprint $table)
        {
            // 文件ID。
            $table->increments('id');

            // 所属者。
            $table->unsignedInteger('user_id');
            $table->string('user_type');
            $table->index([
                'user_id',
                'user_type'
            ]);

            // 文件KEY。
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
        Schema::drop('user_files');
    }
}
