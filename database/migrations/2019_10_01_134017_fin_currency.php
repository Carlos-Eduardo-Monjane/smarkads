<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_currency', function (Blueprint $table) {
          $table->increments('id_fin_currency');
          $table->string('name');
          $table->string('abbreviation');
          $table->integer('status');
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_currency');
    }
}
