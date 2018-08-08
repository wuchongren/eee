<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户ID');
            $table->string('provence')->comment('省份');
            $table->string('city')->comment('市级');
            $table->string('area')->comment('区县');
            $table->string('detail_address')->comment('详细地址');
            $table->string('name')->comment('收货人');
            $table->string('tel')->comment('收货人电话');
            $table->boolean('is_default')->default('0')->comment('是否默认地址，0非，1是');
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
        Schema::dropIfExists('addresses');
    }
}
