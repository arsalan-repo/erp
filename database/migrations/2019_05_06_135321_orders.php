<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('processing');
            $table->timestamps();
      //       $table->foreign('user_id')
      // ->references('id')->on('users')
      // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
        $table->dropForeign(['user_id']);
    }
}
