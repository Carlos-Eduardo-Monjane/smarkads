<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinMassPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_mass_payment', function (Blueprint $table) {
          $table->increments('id_fin_mass_payment');
          $table->integer('status')->default(0);
          $table->integer('id_husky'); 
          $table->integer('id_user')->unsigned(); 
          $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_mass_payment');
    }
}
