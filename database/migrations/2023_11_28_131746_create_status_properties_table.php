<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_properties', function (Blueprint $table) {
            $table->id('idStatus');
            $table->date('startDate');
            $table->date('endDate');
            $table->string('status');
            $table->unsignedBigInteger('property_id');

            $table->foreign('property_id')->references('idProperty')->on('properties')->onDelete('cascade');
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
        Schema::dropIfExists('status_properties');
    }
}
