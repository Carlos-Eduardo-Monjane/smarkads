<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModalUser extends Migration
{
   public function up()
   {
      Schema::create('modal_user', function (Blueprint $table) {
         $table->increments('id_modal_user');
         $table->integer('id_user')->unsigned();
         $table->integer('id_modal')->unsigned();
         $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
         $table->foreign('id_modal')->references('id_modal')->on('modal')->onDelete('cascade');
         $table->timestamps();
         $table->softDeletes();
      });
   }

   public function down()
   {
      Schema::dropIfExists('modal_user');
   }
}
