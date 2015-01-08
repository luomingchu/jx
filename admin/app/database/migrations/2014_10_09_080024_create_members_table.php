<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户表
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');

            // 手机号
            $table->string('mobile', 20)->unique();

            // 昵称
            $table->string('nickname', 64)->nullable();

            // 头像
            $table->unsignedInteger('avatar_id')->default(0);

            // 邮箱
            $table->string('email')
                ->nullable()
                ->unique();

            // 密码
            $table->string('password', 64);

            // 性别
            $table->enum('gender', [Member::GENDER_MAN, Member::GENDER_FEMALE])->default(Member::GENDER_MAN);

            // 出生年月
            $table->date('birthday')->nullable();

            // 真实姓名。
            $table->string('real_name')->default('');

            // 身份证号码。
            $table->string('id_number', 18);

            // 持证照。
            $table->unsignedInteger('id_picture_id')->default(0);

            // 所属省份
            $table->integer('province_id')->default(0);

            // 所属城市
            $table->integer('city_id')->default(0);

            // 所属区/县
            $table->integer('district_id')->default(0);

            // 用户所在地
            $table->string('region_name')->default('');

            // 个性签名
            $table->string('signature')->default('');

            // remember_token
            $table->string('remember_token', 64)->default('');

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
        Schema::drop('members');
    }
}
