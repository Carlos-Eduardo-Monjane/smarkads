<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdManagerReportMonth extends Migration
{
  public function up()
  {
     Schema::create('ad_manager_report_month', function (Blueprint $table) {
        $table->increments('id_ad_manager_report_month');
        $table->date('start_date');
        $table->date('end_date');
        $table->bigInteger('site_id');
        $table->string('site');
        $table->float('earnings_ad_manager',10,2);
        $table->float('earnings_ad_server',10,2);
        $table->float('earnings_ad_total',10,2);
        $table->float('earnings_client_ad_manager',10,2);
        $table->float('earnings_client_ad_server',10,2);
        $table->float('earnings_client_ad_total',10,2);
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('ad_manager_report_month');
  }
}
