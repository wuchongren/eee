<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_name')->comment('名称');
            $table->double('rating')->default(50)->comment('评分');
            $table->integer('shop_id')->comment('所属商家ID');
            $table->integer('menu_category_id')->comment('所属分类');
            $table->decimal('goods_price')->nullable()->comment('价格');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('month_count')->nullable()->comment('月销量');
            $table->integer('rating_count')->nullable()->comment('评分数量');
            $table->string('tips')->nullable()->comment('提示信息');
            $table->integer('satisfy_count')->nullable()->comment('满意度数量');
            $table->float('satisfy_rating')->default(0)->comment('满意度评分');
            $table->string('goods_img')->nullable()->comment('商品图片');
            $table->boolean('status')->default(0)->comment('状态：1上架，0下架');
            $table->integer('stock')->default(0)->comment('状态：1上架，0下架');
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
        Schema::dropIfExists('menuses');
    }
}
