<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FinCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('fin_category', function (Blueprint $table) {
          $table->increments('id_fin_category');
          $table->string('name');
          $table->integer('status')->default(0);
          
          $table->integer('fin_category_id')->unsigned();  // cria a coluna
          $table->foreign('fin_category_id')->references('id_fin_category')->on('fin_category')->onDelete('cascade'); // faz ligação
          
          $table->timestamps();
          $table->softDeletes();
       });
    }
  
    public function down()
    {
       Schema::dropIfExists('fin_category');
    }
}
