<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usr_id')->comment('用户ID');
            $table->integer('shop_id')->comment('商铺ID');
            $table->string('sn')->comment('订单编号');
            $table->string('provence')->comment('省级');
            $table->string('city')->comment('市级');
            $table->string('area')->comment('区县');
            $table->string('detail_address')->comment('详细地址');
            $table->string('tel')->comment('收货人电话');
            $table->string('name')->comment('收货人');
            $table->decimal('total')->comment('总金额');
            $table->boolean('status')->comment('状态(-1:已取消,0:待支付,1:待发货,2:待确认,3:完成)');
            $table->string('out_trade_no')->comment('第三方交易号');
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
        Schema::dropIfExists('orders');
    }
}
