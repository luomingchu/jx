<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 企业管理者
        Schema::create('managers', function (Blueprint $table)
        {
            // 自增主键
            $table->increments('id');

            // 所属企业ID
            $table->unsignedInteger('enterprise_id')->index()->default(0);

            // 用户名
            $table->string('username', 64)
                ->unique();

            // 手机号
            $table->string('mobile', 20)
                ->unique()
                ->nullable();

            // 密码
            $table->string('password', 64);

            // 邮箱
            $table->string('email')
                ->unique()
                ->nullable();

            // 头像
            $table->unsignedInteger('avatar_id')
                ->default(0);

            // 真实姓名
            $table->string('real_name', 64)
                ->default('');

            // 性别。只有男女，没有人妖，重男轻女一下，默认男性。
            $table->enum('gender', [
                Member::GENDER_MAN,
                Member::GENDER_FEMALE
            ])
                ->default(Member::GENDER_MAN);


            // 是否是超级管理员
            $table->enum('is_super', [
                Manager::SUPER_INVALID,
                Manager::SUPER_VALID
            ])
                ->default(Manager::SUPER_INVALID);

            // 上一次登录时间
            $table->timestamp('prev_login_time')
                ->nullable();

            // 最后登录时间
            $table->timestamp('last_login_time')
                ->nullable();

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
        Schema::drop('managers');
    }
}
