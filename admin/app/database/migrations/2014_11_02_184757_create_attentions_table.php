<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttentionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attentions', function (Blueprint $table)
        {
            $table->increments('id');

            // 关注人ID
            $table->unsignedInteger('member_id')
                ->default(0);

            // 被关注人ID
            $table->unsignedInteger('friend_id')
                ->default(0);

            // 关注关系
            $table->enum('relationship', [
                Attention::RELATIONSHIP_UNILATERAL,
                Attention::RELATIONSHIP_MUTUAL
            ])
                ->default(Attention::RELATIONSHIP_UNILATERAL);

            // 知否关注指帮信息
            $table->enum('zbond_show', [
                Attention::ZBOND_SHOW_YES,
                Attention::ZBOND_SHOW_NO
            ])
                ->default(Attention::ZBOND_SHOW_YES);

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
        Schema::drop('attentions');
    }
}
