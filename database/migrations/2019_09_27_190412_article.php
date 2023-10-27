<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Article extends Migration
{
  public function up()
  {
     Schema::create('article', function (Blueprint $table) {
        $table->increments('id_article');
        $table->string('subject');
        $table->text('description');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('article');
  }
}
