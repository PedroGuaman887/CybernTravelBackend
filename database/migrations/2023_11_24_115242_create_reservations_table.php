<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('idReservations');
            $table->date('startDate');
            $table->integer('totalAmount');
            $table->date('endDate');
            $table->unsignedBigInteger('idProperty');
            $table->unsignedBigInteger('idUser');  
            $table->foreign('idProperty')->references('idProperty')->on('properties');
            $table->foreign('idUser')->references('idUser')->on('users');
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
        Schema::dropIfExists('reservations');
    }
}
