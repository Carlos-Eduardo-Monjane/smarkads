<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PrebidVersion extends Migration
{
  public function up()
  {
     Schema::create('prebid_version', function (Blueprint $table) {
        $table->increments('id_prebid_version');
        $table->string('name')->nullable();
        $table->string('version');
        $table->integer('enabled')->default(0);
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('prebid_version');
  }
}
