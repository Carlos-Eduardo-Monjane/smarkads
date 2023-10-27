<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdmanagerAdvertiserReport extends Migration
{
  public function up()
  {
     Schema::create('admanager_advertiser_report', function (Blueprint $table) {
        $table->increments('id_admanager_advertiser_report');
        $table->date('date');
        $table->biginteger('order_id');
        $table->biginteger('impressions');
        $table->integer('clicks');
        $table->float('ctr', 10,2);
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('admanager_advertiser_report');
  }
}
