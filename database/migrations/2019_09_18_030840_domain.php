<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Domain extends Migration
{
  public function up()
  {
     Schema::create('domain', function (Blueprint $table) {
        $table->increments('id_domain');
        $table->string('name');
        $table->text('observation')->nullable();
        $table->float('rev_share_admanager',10,2)->default(30.0);
        $table->float('rev_share_adserver',10,2)->default(50.0);
        $table->float('rev_share_account_manager',10,2)->nullable();
        $table->bigInteger('page_views');
        $table->string('hash_uniq')->nullable();
        $table->string('file_do')->nullable();
        $table->string('google_analytcs_id')->nullable();
        $table->string('head_bidder_id')->nullable();
        $table->string('login')->nullable();
        $table->string('password')->nullable();
        $table->integer('status_checklist')->default(0);
        $table->date('posted_at')->nullable();
        $table->string('key_recaptcha')->nullable();
        $table->integer('id_domain_category')->unsigned();
        $table->integer('id_account_manager')->unsigned()->nullable();
        $table->integer('id_user')->unsigned();
        $table->integer('id_prebid_version')->unsigned();
        $table->integer('id_domain_status')->unsigned()->default(1);
        $table->foreign('id_domain_category')->references('id_domain_category')->on('domain_category')->onDelete('cascade');
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_domain_status')->references('id_domain_status')->on('domain_status')->onDelete('cascade');
        $table->foreign('id_account_manager')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_prebid_version')->references('id_prebid_version')->on('prebid_version')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('domain');
  }
}
