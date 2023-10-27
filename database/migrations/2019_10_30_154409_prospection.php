<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Prospection extends Migration
{
  public function up()
  {
     Schema::create('prospection', function (Blueprint $table) {
        $table->increments('id_prospection');
        $table->string('name');
        $table->string('email');
        $table->string('domain');
        $table->string('subject');
        $table->text('message');
        $table->integer('id_emails_template')->unsigned()->nullable();
        $table->foreign('id_emails_template')->references('id_emails_template')->on('emails_template')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('prospection');
  }
}
