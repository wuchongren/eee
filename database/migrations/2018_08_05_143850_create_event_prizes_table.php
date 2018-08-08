<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_prizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->comment('活动ID');
            $table->string('name')->comment('奖品名称');
            $table->text('description')->nullable()->comment('奖品详情');
            $table->integer('user_id')->comment('中奖商家ID')->default(0);
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
        Schema::dropIfExists('event_prizes');
    }
}
