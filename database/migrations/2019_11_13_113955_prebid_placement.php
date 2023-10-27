<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrebidPlacement extends Migration
{
  public function up()
  {
     Schema::create('prebid_placement', function (Blueprint $table) {
        $table->increments('id_prebid_placement');
        $table->string('placement')->nullable();
        $table->string('slot_sizes');
        $table->string('publisherId')->nullable();
        $table->string('placementId')->nullable();
        $table->string('zoneId');
        $table->string('region')->nullable();
        $table->string('pageId')->nullable();
        $table->integer('id_prebid_bids')->unsigned();
        $table->foreign('id_prebid_bids')->references('id_prebid_bids')->on('prebid_bids')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('prebid_placement');
  }
}
