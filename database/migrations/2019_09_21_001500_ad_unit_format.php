<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdUnitFormat extends Migration
{
  public function up()
  {
    Schema::create('ad_unit_format', function (Blueprint $table) {
      $table->increments('id_ad_unit_format');
      $table->string('name');
      $table->string('page');
      $table->integer('quantity');
      $table->string('sizes');
      $table->integer('device');
      $table->string('position')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('id_ad_unit_format');
  }
}
