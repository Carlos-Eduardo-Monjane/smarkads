<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainCategory extends Migration
{
  public function up()
  {
    Schema::create('domain_category', function (Blueprint $table) {
      $table->increments('id_domain_category');
      $table->string('name');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('domain_category');
  }
}
