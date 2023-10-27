<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Priority extends Migration
{
  public function up()
  {
    Schema::create('priority', function (Blueprint $table) {
      $table->increments('id_priority');
      $table->string('name');
      $table->string('earnings');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('priority');
  }
}
