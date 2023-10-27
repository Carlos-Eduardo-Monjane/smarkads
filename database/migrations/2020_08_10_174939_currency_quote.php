<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CurrencyQuote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
  {
     Schema::create('currency_quote', function (Blueprint $table) {
        $table->increments('id');
        $table->string('code');
        $table->string('codein');
        $table->float('high', 10,8);
        $table->float('low', 10,8);
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('currency_quote');
  }
}
