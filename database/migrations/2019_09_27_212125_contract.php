<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Contract extends Migration
{
  public function up()
  {
     Schema::create('contract', function (Blueprint $table) {
        $table->increments('id_contract');
        $table->string('title');
        $table->text('description');
        $table->integer('status')->default(0);
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('contract');
  }
}
