<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_bank', function (Blueprint $table) {
          $table->increments('id_fin_bank');
          $table->string('name');
          $table->float('valor',10,2);
          $table->string('currency');
          $table->integer('status')->default(0);
          $table->integer('id_fin_currency')->unsigned();
          $table->foreign('id_fin_currency')->references('id_fin_currency')->on('fin_currency')->onDelete('cascade'); 
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_bank');
    }
}
