<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainAdsTxt extends Migration
{
  public function up()
  {
    Schema::create('domain_ads_txt', function (Blueprint $table) {
      $table->increments('id_domain_ads_txt');
      $table->text('script');
      $table->integer('id_domain')->unsigned();
      $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('domain_ads_txt');
  }
}
