<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrebidBids extends Migration
{
  public function up()
  {
     Schema::create('prebid_bids', function (Blueprint $table) {
        $table->increments('id_prebid_bids');
        $table->string('name');
        $table->string('bidder');
        $table->string('reserve');
        $table->string('network')->nullable();
        $table->string('bid_floor')->nullable();
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('prebid_bids');
  }
}
