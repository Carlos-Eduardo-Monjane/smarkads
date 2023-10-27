<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignmentServiceHour extends Migration
{
  public function up()
  {
     Schema::create('assignment_service_hour', function (Blueprint $table) {
        $table->increments('id_assignment_service_hour');
        $table->datetime('start');
        $table->datetime('end')->nullable();
        $table->integer('status')->default(0);
        $table->integer('id_user')->unsigned();
        $table->integer('id_assignment')->unsigned();
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_assignment')->references('id_assignment')->on('assignment')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('assignment_service_hour');
  }
}
