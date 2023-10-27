<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinMovimentation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_movimentation', function (Blueprint $table) {
          $table->increments('id_fin_movimentation');
          $table->date('date_expiry')->nullable();
          $table->date('date_payment')->nullable();
          $table->string('number_doc')->nullable();
          $table->float('value',10,2)->nullable();
          $table->string('file')->nullable();
          $table->string('currency')->nullable();
          $table->string('month_reference')->nullable();
          $table->text('obs')->nullable();
          $table->integer('id_client')->unsigned(); 
          $table->integer('id_user')->unsigned(); 
          $table->integer('id_fin_bank')->unsigned(); 
          $table->integer('id_fin_category')->unsigned(); 
          $table->integer('id_fin_form')->unsigned(); 
          $table->integer('status')->default(0); 
          $table->integer('id_fin_currency')->unsigned();
          $table->foreign('id_fin_currency')->references('id_fin_currency')->on('fin_currency')->onDelete('cascade'); 
          $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade'); 
          $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade'); 
          $table->foreign('id_fin_bank')->references('id_fin_bank')->on('fin_bank')->onDelete('cascade'); 
          $table->foreign('id_fin_category')->references('id_fin_category')->on('fin_category')->onDelete('cascade'); 
          $table->foreign('id_fin_form')->references('id_fin_form')->on('fin_form')->onDelete('cascade'); 
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_movimentation');
    }
}
