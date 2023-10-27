<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainScripts extends Migration
{

  public function up()
  {
    Schema::create('domain_scripts', function (Blueprint $table) {
      $table->increments('id_domain_scripts');
      $table->text('header')->nullable();
      $table->text('footer')->nullable();
      $table->text('after_body')->nullable();
      $table->integer('device');
      $table->integer('id_domain')->unsigned();
      $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('domain_scripts');
  }
}
