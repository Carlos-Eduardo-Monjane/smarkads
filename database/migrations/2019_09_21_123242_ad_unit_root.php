<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdUnitRoot extends Migration
{
  public function up()
  {
     Schema::create('ad_unit_root', function (Blueprint $table) {
        $table->increments('id_ad_unit_root');
        $table->bigInteger('ad_unit_root_id');
        $table->string('ad_unit_root_code');
        $table->string('ad_unit_root_name');
        $table->integer('id_domain')->unsigned();
        $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('ad_unit_root');
  }
}
