<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserLog extends Migration
{

  public function up()
  {
     Schema::create('user_log', function (Blueprint $table) {
        $table->increments('id_user_log');
        $table->text('query');
        $table->integer('id_user')->unsigned()->nullable();
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('user_log');
  }
}
