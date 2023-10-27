<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MessageDefault extends Migration
{
  public function up()
  {
     Schema::create('message_default', function (Blueprint $table) {
        $table->increments('id_message_default');
        $table->string('subject');
        $table->text('message');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('message_default');
  }
}
