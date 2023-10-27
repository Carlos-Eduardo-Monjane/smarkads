<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainEarningsInvalid extends Migration
{
  public function up()
  {
     Schema::create('domain_earnings_invalid', function (Blueprint $table) {
        $table->increments('id_domain_earnings_invalid');
        $table->float('value',10,2);
        $table->integer('month');
        $table->integer('year');
        $table->text('description');
        $table->integer('id_domain')->unsigned()->nullable();
        $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('domain_earnings_invalid');
  }
}
