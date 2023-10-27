<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainNotification extends Migration
{
  public function up()
  {
     Schema::create('domain_notification', function (Blueprint $table) {
        $table->increments('id_domain_notification');
        $table->string('subject');
        $table->text('message');
        $table->integer('id_domain')->unsigned()->nullable();
        $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('domain_notification');
  }
}
