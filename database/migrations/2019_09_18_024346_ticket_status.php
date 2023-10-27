<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketStatus extends Migration
{
  public function up()
  {
    Schema::create('ticket_status', function (Blueprint $table) {
      $table->increments('id_ticket_status');
      $table->string('name');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('ticket_status');
  }
}
