<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DomainConfirmChecklist extends Migration
{
  public function up()
  {
     Schema::create('domain_confirm_checklist', function (Blueprint $table) {
        $table->increments('id_domain_confirm_checklist');
        $table->integer('id_domain')->unsigned();
        $table->integer('id_domain_checklist')->unsigned();
        $table->foreign('id_domain')->references('id_domain')->on('domain')->onDelete('cascade');
        $table->foreign('id_domain_checklist')->references('id_domain_checklist')->on('domain_checklist')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('domain_confirm_checklist');
  }
}
