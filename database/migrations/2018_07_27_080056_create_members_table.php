<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->comment('会员名称');
            $table->string('password')->comment('密码');
            $table->string('tel')->comment('手机');
            $table->decimal('money')->default(0)->comment('账户余额');
            $table->integer('jifen')->default(0)->comment('jif');
            $table->boolean('status')->default(1)->comment('状态：0，禁用，1正常');
            $table->timestamps();
            $table->rememberToken()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
