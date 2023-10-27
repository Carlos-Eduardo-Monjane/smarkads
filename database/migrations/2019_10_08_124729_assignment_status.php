<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignmentStatus extends Migration
{
  public function up()
  {
    Schema::create('assignment_status', function (Blueprint $table) {
      $table->increments('id_assignment_status');
      $table->string('name');
      $table->string('color');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('assignment_status');
  }
}
