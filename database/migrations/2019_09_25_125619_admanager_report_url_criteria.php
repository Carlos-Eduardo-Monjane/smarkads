<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdmanagerReportUrlCriteria extends Migration
{
  public function up()
  {
     Schema::create('admanager_report_url_criteria', function (Blueprint $table) {
        $table->increments('id_admanager_report_url_criteria');
        $table->date('date');
        $table->biginteger('site_id');
        $table->string('site');
        $table->biginteger('ad_unit_id');
        $table->string('ad_unit');
        $table->biginteger('impressions');
        $table->integer('clicks');
        $table->float('ctr', 10,2);
        $table->float('ecpm', 10,2);
        $table->float('ecpm_client', 10,2);
        $table->float('earnings', 10,2);
        $table->float('earnings_client', 10,2);
        $table->float('active_view_viewable', 10,2);
        $table->string('url_id');
        $table->string('url');
        $table->string('custon_key');
        $table->string('custon_value');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('admanager_report_url_criteria');
  }
}
