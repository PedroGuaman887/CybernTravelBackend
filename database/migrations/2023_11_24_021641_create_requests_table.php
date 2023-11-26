<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id('idRequests');
            $table->date('startDate');
            $table->date('endDate');
            $table->dateTime('dateRequest');
            $table->string('status');
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
        Schema::dropIfExists('requests');
    }
}
