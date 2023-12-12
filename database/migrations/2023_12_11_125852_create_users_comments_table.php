<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_comments', function (Blueprint $table) {
            $table->id('idUserComments');
            $table->string('comment');
            $table->date('commentDate');

            $table->unsignedBigInteger('sender_user_id');
            $table->foreign('sender_user_id')->references('idUser')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('receiver_user_id');
            $table->foreign('receiver_user_id')->references('idUser')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('users_comments');
    }
}
