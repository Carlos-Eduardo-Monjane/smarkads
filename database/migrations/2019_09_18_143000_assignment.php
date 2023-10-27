<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Assignment extends Migration
{
  public function up()
  {
     Schema::create('assignment', function (Blueprint $table) {
        $table->increments('id_assignment');
        $table->string('subject');
        $table->text('description');
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('id_assignment_status')->unsigned();
        $table->integer('id_priority')->unsigned();
        $table->integer('id_domain')->unsigned();
        $table->integer('id_department')->unsigned();
        $table->integer('id_ticket')->unsigned()->nullable();
        $table->foreign('id_assignment_status')->references('id_assignment_status')->on('assignment_status')->onDelete('cascade');
        $table->foreign('id_priority')->references('id_priority')->on('priority')->onDelete('cascade');
        $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
        $table->foreign('id_department')->references('id_department')->on('department')->onDelete('cascade');
        $table->foreign('id_ticket')->references('id_ticket')->on('ticket')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('assignment');
  }
}
