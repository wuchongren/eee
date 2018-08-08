<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->comment('活动标题');
            $table->text('content')->comment('活动内容跟');
            $table->boolean('status')->default(0)->comment('状态：0，未启用，1进行中，2结束');
            $table->integer('start_time')->comment('开始时间');
            $table->integer('end_time')->comment('结束时间时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotions');
    }
}
