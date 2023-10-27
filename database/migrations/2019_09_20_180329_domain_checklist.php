<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainChecklist extends Migration
{
  public function up()
  {
    Schema::create('domain_checklist', function (Blueprint $table) {
      $table->increments('id_domain_checklist');
      $table->string('name');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down()
  {
    Schema::dropIfExists('domain_checklist');
  }
}
