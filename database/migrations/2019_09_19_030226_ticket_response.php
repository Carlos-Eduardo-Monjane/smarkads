<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketResponse extends Migration
{
  public function up()
  {
     Schema::create('ticket_response', function (Blueprint $table) {
        $table->increments('id_ticket_response');
        $table->text('response');
        $table->integer('type');
        $table->integer('id_ticket')->unsigned();
        $table->foreign('id_ticket')->references('id_ticket')->on('ticket')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('ticket_response');
  }
}
