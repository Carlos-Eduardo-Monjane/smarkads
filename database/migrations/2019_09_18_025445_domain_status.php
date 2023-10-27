<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainStatus extends Migration
{
  public function up()
  {
    Schema::create('domain_status', function (Blueprint $table) {
      $table->increments('id_domain_status');
      $table->string('name');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('domain_status');
  }
}
