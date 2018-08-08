<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name')->comment('店铺名称');
            $table->integer('shop_category_id')->comment('店铺分类ID');
            $table->string('shop_img')->nullable()->comment('店铺图片');
            $table->float('shop_rating')->default(100)->comment('评分');
            $table->boolean('brand')->default(1)->comment('是否是品牌');
            $table->boolean('on_time')->default(1)->comment('是否准时送达');
            $table->boolean('fengniao')->default(1)->comment('是否蜂鸟配送');
            $table->boolean('bao')->default(1)->comment('是否保标记');
            $table->boolean('piao')->default(1)->comment('是否票标记');
            $table->boolean('zhun')->default(1)->comment('是否准标记');
            $table->decimal('start_send')->nullable()->comment('起送金额');
            $table->decimal('send_cost',10,2)->comment('配送费');
            $table->string('notice')->nullable()->comment('店公告');
            $table->string('discount')->nullable()->comment('优惠信息');
            $table->integer('status')->default(0)->comment('状态:1正常,0禁用,-1待审核');
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
        Schema::dropIfExists('shops');
    }
}
