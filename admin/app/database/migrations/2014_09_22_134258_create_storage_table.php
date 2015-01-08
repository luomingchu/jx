<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 存储管理。
        Schema::create('storage', function (Blueprint $table)
        {
            // md5。
            // 文件使用md5作为 hash_id。
            $table->char('hash', 32)->primary();

            // 字节大小。
            $table->integer('size')
                ->unsigned()
                ->default(0);

            // 宽度。
            $table->integer('width')
                ->unsigned()
                ->default(0);

            // 高度。
            $table->integer('height')
                ->unsigned()
                ->default(0);

            // Mime。
            $table->string('mime')->default('');

            // 时长（秒）。
            $table->double('seconds', 18, 8)
                ->unsigned()
                ->default(0);

            // 文件格式。
            $table->string('format')->default('');

            // 文件名
            $table->string('filename');

            // 文件路径。
            $table->string('path')->default('');

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
        Schema::drop('storage');
    }
}
