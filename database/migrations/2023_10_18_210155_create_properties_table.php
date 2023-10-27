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
            $table->string('propertyPicture');
            $table->string('propertyOperation');
            $table->string('propertyType');
            $table->string('propertyAddress');
            $table->string('propertyDescription');
            $table->string('propertyServices');
            $table->string('propertyStatus');
            $table->integer('propertyAmount');
            $table->integer('propertyAbility');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('holiday_id');

            $table->foreign('property_id')->references('idProperty')->on('properties')->onDelete('cascade');
            $table->foreign('holiday_id')->references('idHolidays')->on('holidays')->onDelete('cascade');

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
        Schema::dropIfExists('properties_holidays');
    }
}