<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id('idProperty');

            $table->string('propertyName');
            $table->string('propertyOperation');
            $table->string('propertyType');
            $table->string('propertyAddress');
            $table->string('propertyDescription');
            $table->string('propertyServices');
            $table->string('propertyStatus');
            $table->integer('propertyAmount');
            $table->integer('propertyAbility');
            $table->string('propertyCity');
            $table->string('propertyCroquis');
            $table->integer('propertyRooms');
            $table->integer('propertyBathrooms');
            $table->integer('propertyBeds');
            $table->string('propertyRules');
            $table->string('propertySecurity');


            $table->unsignedBigInteger('host_id');

            $table->foreign('host_id')->references('idUser')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('properties');
    }
}
