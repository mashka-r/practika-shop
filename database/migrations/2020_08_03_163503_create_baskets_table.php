<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasketsTable extends Migration
{
    public function up()
    {
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('temporary_key')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('count')->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
        });
    }
    public function down()
    {
        Schema::dropIfExists('baskets');
    }   

}
