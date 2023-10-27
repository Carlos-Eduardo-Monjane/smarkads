<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alert extends Migration
{
  public function up()
  {
     Schema::create('alert', function (Blueprint $table) {
        $table->increments('id_alert');
        $table->string('title');
        $table->text('text');
        $table->integer('status')->default(0);
        $table->integer('id_user')->unsigned()->nullable();
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('alert');
  }
}
