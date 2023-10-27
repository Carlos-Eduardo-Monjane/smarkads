<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticleRole extends Migration
{
  public function up()
  {
     Schema::create('article_role', function (Blueprint $table) {
        $table->increments('id_article_role');
        $table->integer('id_role')->unsigned();
        $table->integer('id_article')->unsigned();
        $table->foreign('id_role')->references('id')->on('roles')->onDelete('cascade');
        $table->foreign('id_article')->references('id_article')->on('article')->onDelete('cascade');
        $table->timestamps();
        $table->softDeletes();
     });
  }

  public function down()
  {
     Schema::dropIfExists('article_role');
  }
}
