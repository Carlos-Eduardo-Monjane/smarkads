<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration
{
  public function up()
  {
    Schema::create('settings', function (Blueprint $table) {
      $table->increments('id_settings');
      $table->string('name_system');
      $table->string('logo_white');
      $table->string('logo_black');
      $table->string('fiv_icon');
      $table->string('backgroud_login');
      $table->string('email_ticket');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('settings');
  }
}
