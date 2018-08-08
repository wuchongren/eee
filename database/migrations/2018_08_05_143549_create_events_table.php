<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('名称');
            $table->text('content')->nullable()->comment('详情');
            $table->integer('start_time')->comment('报名开始时间');
            $table->integer('end_time')->comment('报名结束时间');
            $table->integer('prize_time')->comment('报名结束时间');
            $table->integer('num')->comment('报名人数限制');
            $table->boolean('is_prized')->default(0)->comment('是否开奖:0未开，1已开');
            $table->integer('sign_num')->default(0)->comment('已报名人数');
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
        Schema::dropIfExists('events');
    }
}
