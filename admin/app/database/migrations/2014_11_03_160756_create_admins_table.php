<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // 管理员。
        Schema::create('admins', function (Blueprint $table)
        {
            $table->increments('id');

            // 用户名
            $table->string('username')->unique();

            // 手机号
            $table->string('mobile', 20)
                ->unique()
                ->nullable();

            // 邮箱
            $table->string('email')
                ->unique()
                ->nullable();

            // 密码
            $table->string('password', 64);

            // 头像
            $table->unsignedInteger('avatar_id')->default(0);

            // 真实姓名。
            $table->string('real_name')->default('');

            // remember_token
            $table->string('remember_token', 64);

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
        Schema::drop('admins');
    }
}
