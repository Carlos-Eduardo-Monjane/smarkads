<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AssignmentUser extends Migration
{
  public function up()
  {
     Schema::create('assignment_user', function (Blueprint $table) {
        $table->increments('id_assignment_user');
        $table->integer('id_assignment')->unsigned();
        $table->integer('id_user')->unsigned();
        $table->foreign('id_assignment')->references('id_assignment')->on('assignment')->onDelete('cascade');
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('assignment_user');
  }
}
