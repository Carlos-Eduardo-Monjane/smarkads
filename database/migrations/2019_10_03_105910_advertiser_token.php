<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdvertiserToken extends Migration
{
  public function up()
  {
    Schema::create('advertiser_token', function (Blueprint $table) {
      $table->increments('id_advertiser_token');
      $table->string('token');
      $table->datetime('expire');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('advertiser_token');
  }
}
