<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Clients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('distributor_id');
            $table->string('name');
            $table->string('phone');
            $table->string('whatsapp_number');
            $table->string('email');
            $table->string('password');
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->string('code');
            $table->string('address');
            $table->string('city');
            $table->string('region');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
