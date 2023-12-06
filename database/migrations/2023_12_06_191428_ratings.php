<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ratings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id('idRatings');
            $table->integer('ratingCleaning');    
            $table->integer('ratingPunctuality'); 
            $table->integer('ratingFriendliness'); 
            $table->string('ratingComment')->nullable();
            $table->unsignedBigInteger('idProperty'); 
            $table->unsignedBigInteger('idUser'); 
            
            $table->unsignedBigInteger('idReservations');

            $table->foreign('idUser')->references('idUser')->on('users');
            $table->foreign('idProperty')->references('idProperty')->on('properties')->onDelete('cascade');
           

            $table->foreign('idReservations')->references('idReservations')->on('reservations');
            
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
        Schema::dropIfExists('ratings');
    }
}
