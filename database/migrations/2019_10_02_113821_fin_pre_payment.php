<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinPrePayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_pre_payment', function (Blueprint $table) {
          $table->increments('id_fin_pre_payment');
          $table->integer('id_user')->unsigned();
          $table->integer('id_client')->unsigned();
          $table->integer('id_fin_currency')->unsigned();
          $table->string('date');
          $table->text('addids');
          $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade'); 
          $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
          $table->foreign('id_fin_currency')->references('id_fin_currency')->on('fin_currency')->onDelete('cascade'); 
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_pre_payment');
    }
}
