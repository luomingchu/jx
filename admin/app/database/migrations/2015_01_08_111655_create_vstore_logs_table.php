<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVstoreLogsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 指店记录表
        Schema::create('vstore_logs', function (Blueprint $table)
        {
            // 主键ID
            $table->increments('id');

            // 所属指店
            $table->unsignedInteger('vstore_id', false);

            // 操作人[买家or企业]
            $table->morphs('user');

            // 记录的内容
            $table->string('content')->default('');

            // 初始状态
            $table->enum('original_status', [
                Vstore::STATUS_INIT,
                Vstore::STATUS_OPEN,
                Vstore::STATUS_CLOSE,
                Vstore::STATUS_ENTERPRISE_AUDITING,
                Vstore::STATUS_ENTERPRISE_AUDITERROR,
                Vstore::STATUS_ENTERPRISE_AUDITED,
                Vstore::STATUS_MEMBER_GETED
            ]);

            // 当前状态
            $table->enum('current_status', [
                Vstore::STATUS_OPEN,
                Vstore::STATUS_CLOSE,
                Vstore::STATUS_ENTERPRISE_AUDITING,
                Vstore::STATUS_ENTERPRISE_AUDITERROR,
                Vstore::STATUS_ENTERPRISE_AUDITED,
                Vstore::STATUS_MEMBER_GETED
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
        Schema::drop('vstore_logs');
    }
}
