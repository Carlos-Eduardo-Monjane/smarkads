<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Advertiser extends Migration
{

  public function up()
  {
    Schema::create('advertiser', function (Blueprint $table) {
      $table->increments('id_advertiser');
      $table->string('title');
      $table->text('description');
      $table->string('image');
      $table->string('url');
      $table->biginteger('order_id')->nullable();
      $table->biginteger('line_item_id')->nullable();
      $table->float('cpc',10,2);
      $table->string('type_campaign');
      $table->integer('advertiser_id_integration');
      $table->integer('status_ad_manager')->default(0);
      $table->datetime('start_date');
      $table->datetime('end_date');
      $table->biginteger('status_approved')->default(0);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('advertiser');
  }
}
