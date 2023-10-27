<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('CMP');
            $table->string('origem');
            $table->string('utms');
            $table->string('type_profile');
            $table->string('email')->unique();
            $table->integer('id_user')->unsigned();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('id_user_type')->unsigned();
            $table->text('invite_admanager');
            $table->integer('send_invite_admanager')->default(0);
            $table->integer('status_admanager')->default(0);
            $table->integer('status_waiting')->default(0);
            $table->integer('disapproved')->default(0);
            $table->text('observation_disapproved')->nullable();
            $table->text('observation_waiting')->nullable();
            $table->string('whatsapp');
            $table->rememberToken();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_user_type')->references('id_user_type')->on('user_type')->onDelete('cascade');
            $table->timestamp('enter_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
