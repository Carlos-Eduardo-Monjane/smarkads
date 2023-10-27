<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pages extends Migration
{
   public function up()
   {
      Schema::create('pages', function (Blueprint $table) {
         $table->increments('id_pages');
         $table->string('icon');
         $table->string('name');
         $table->string('image');
         $table->string('url');
         $table->string('position');
         $table->integer('new')->default(0);
         $table->string('link');
         $table->integer('open_page')->default(0);
         $table->integer('type')->default(1);
         $table->timestamps();
         $table->softDeletes();
      });
   }

   public function down()
   {
      Schema::dropIfExists('pages');
   }
}
