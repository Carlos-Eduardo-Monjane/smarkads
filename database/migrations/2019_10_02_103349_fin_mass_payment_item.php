<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinMassPaymentItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_mass_payment_item', function (Blueprint $table) {
          $table->increments('id_fin_mass_payment_item');
          $table->string('token');
          $table->float('tax',10,2);
          $table->float('value',10,2);
          $table->float('final_value',10,2);
          $table->text('addids');
          $table->text('obs');
          $table->integer('id_user')->unsigned();
          $table->integer('id_client')->unsigned();
          $table->integer('id_fin_mass_payment')->unsigned();
          $table->integer('id_fin_movimentation')->unsigned();
          $table->integer('id_fin_currency')->unsigned();
          $table->foreign('id_fin_currency')->references('id_fin_currency')->on('fin_currency')->onDelete('cascade'); 
          $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
          $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade'); 
          $table->foreign('id_fin_mass_payment')->references('id_fin_mass_payment')->on('fin_mass_payment')->onDelete('cascade'); 
          $table->foreign('id_fin_movimentation')->references('id_fin_movimentation')->on('fin_movimentation')->onDelete('cascade'); 
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_mass_payment_item');
    }
}
