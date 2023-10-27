<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdsTxtDefault extends Migration
{
  public function up()
  {
     Schema::create('ads_txt_default', function (Blueprint $table) {
        $table->increments('id_ads_txt_default');
        $table->text('ads_txt');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('ads_txt_default');
  }
}
