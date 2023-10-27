<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContractUser extends Migration
{
  public function up()
  {
     Schema::create('contract_user', function (Blueprint $table) {
        $table->increments('id_contract_user');
        $table->date('start_date');
        $table->date('end_date');
        $table->float('rev_share',10,2)->default(30);
        $table->integer('status')->default(0);
        $table->string('signature')->nullable();
        $table->string('signature_admin')->nullable();
        $table->integer('id_user')->unsigned();
        $table->integer('id_contract')->unsigned();
        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_contract')->references('id_contract')->on('contract')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('contract_user');
  }
}
