<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('code_id');
            $table->integer('qty');
            $table->string('unit');
            $table->string('image');
            $table->text('description');
            $table->foreign( 'category_id' )->references( 'id' )->on( 'categories' )->onDelete( 'cascade' );
            $table->foreign( 'type_id' )->references( 'id' )->on( 'types' )->onDelete( 'cascade' );
            $table->foreign( 'code_id' )->references( 'id' )->on( 'colors' )->onDelete( 'cascade' );

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
