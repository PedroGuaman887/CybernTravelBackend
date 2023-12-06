<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsHostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_hosts', function (Blueprint $table) {
            $table->id('idNotificationsHosts');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('nameProperty');
            $table->string('nameUser');
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
        Schema::dropIfExists('notifications_hosts');
    }
}
