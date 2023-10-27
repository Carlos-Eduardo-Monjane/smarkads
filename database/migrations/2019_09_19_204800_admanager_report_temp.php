<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdmanagerReportTemp extends Migration
{
  public function up()
  {
     Schema::create('admanager_report_temp', function (Blueprint $table) {
        $table->increments('id_admanager_report_temp');
        $table->date('date');
        $table->biginteger('site_id');
        $table->string('site');
        $table->biginteger('ad_unit_id');
        $table->string('ad_unit');
        $table->biginteger('impressions');
        $table->integer('clicks');
        $table->float('earnings', 10,2);
        $table->float('earnings_client', 10,2);
        $table->float('active_view_viewable', 10,2);
        $table->integer('status_payment')->default(0);
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('admanager_report_temp');
  }
}
