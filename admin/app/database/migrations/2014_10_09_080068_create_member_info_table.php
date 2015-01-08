<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberInfoTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户信息表
        Schema::create('member_info', function (Blueprint $table)
        {
            // 自增主键
            $table->increments('id');

            // 对应用户id
            $table->unsignedInteger('member_id');

            // 对应企业id
            $table->integer('enterprise_id');

            // 会员类型
            $table->enum('kind', [MemberInfo::KIND_BUYER, MemberInfo::KIND_SELLER, MemberInfo::KIND_BUYER]);

            // 会员等级
            $table->integer('level')->default(0);

            // 指币总收益
            $table->unsignedInteger('coin_amount')
                ->default(0);

            // 指币余额。
            $table->integer('coin')
                ->default(0);

            // 内购额总收益
            $table->decimal('insource_amount', 10, 2)
                ->default(0);

            // 内购额余额。
            $table->decimal('insource', 10, 2)
                ->default(0);

            // 用户关注的指店。
            $table->unsignedInteger('attention_vstore_id')
                ->default(0);

            // 指友数
            $table->unsignedInteger('friends_quantity')
                ->default(0);

            // 总的收益佣金
            $table->decimal('brokerage_amount')
                ->default(0);

            // 剩余多少佣金未结算
            $table->decimal('remain_brokerage')
                ->default(0);

            // 企业备注
            $table->string('remark', 500)->default('');


            // 登录的session_id
            $table->string('session_id')->default('');

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
        Schema::drop('member_info');
    }
}
