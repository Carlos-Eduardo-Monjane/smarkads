<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Modal extends Migration
{
   public function up()
  {
     Schema::create('modal', function (Blueprint $table) {
        $table->increments('id_modal');
        $table->string('image');
        $table->string('status');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('modal');
  }
}
