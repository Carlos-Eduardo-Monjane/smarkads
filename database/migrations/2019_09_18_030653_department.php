<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Department extends Migration
{
  public function up()
  {
    Schema::create('department', function (Blueprint $table) {
      $table->increments('id_department');
      $table->string('name');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('department');
  }
}
