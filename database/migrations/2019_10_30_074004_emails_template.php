<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailsTemplate extends Migration
{
  public function up()
  {
     Schema::create('emails_template', function (Blueprint $table) {
        $table->increments('id_emails_template');
        $table->string('name');
        $table->text('html');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('emails_template');
  }
}
