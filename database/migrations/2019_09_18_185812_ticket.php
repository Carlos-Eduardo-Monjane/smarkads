<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Ticket extends Migration
{
  public function up()
  {
     Schema::create('ticket', function (Blueprint $table) {
        $table->increments('id_ticket');
        $table->string('subject');
        $table->text('description');

        $table->integer('id_department')->unsigned();
        $table->integer('id_ticket_status')->unsigned();
        $table->integer('id_domain')->unsigned();
        $table->integer('id_priority')->unsigned();

        $table->foreign('id_department')->references('id_department')->on('department')->onDelete('cascade');
        $table->foreign('id_ticket_status')->references('id_ticket_status')->on('ticket_status')->onDelete('cascade');
        $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
        $table->foreign('id_priority')->references('id_priority')->on('priority')->onDelete('cascade');

        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('ticket');
  }
}
