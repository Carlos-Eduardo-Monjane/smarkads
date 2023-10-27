<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdUnit extends Migration
{
  public function up()
  {
     Schema::create('ad_unit', function (Blueprint $table) {
        $table->increments('id_ad_unit');
        $table->bigInteger('ad_unit_id');
        $table->string('ad_unit_name');
        $table->string('ad_unit_code');
        $table->string('ad_unit_status');
        $table->string('position')->nullable();
        $table->integer('device');
        $table->string('sizes');
        $table->string('shortcode')->nullable();
        $table->string('element_html')->nullable();
        $table->integer('position_element')->nullable();
        $table->integer('id_ad_unit_root')->unsigned();
        $table->foreign('id_ad_unit_root')->references('id_ad_unit_root')->on('ad_unit_root')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('ad_unit');
  }
}
