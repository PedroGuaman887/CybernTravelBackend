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
            $table->datetime('propertyStartA');
            $table->datetime('propertyEndA');
            $table->datetime('propertyStartB');
            $table->datetime('propertyEndB');
            $table->datetime('propertyStartC');
            $table->datetime('propertyEndC');
            $table->datetime('propertyStartD');
            $table->datetime('propertyEndD');
            $table->datetime('propertyStartE');
            $table->datetime('propertyEndE');
            $table->datetime('propertyStartF');
            $table->datetime('propertyEndF');
            $table->datetime('propertyStartG');
            $table->datetime('propertyEndG');
            $table->datetime('propertyStartH');
            $table->datetime('propertyEndH');
            $table->integer('propertyAmountA');
            $table->integer('propertyAmountB');
            $table->integer('propertyAmountC');
            $table->integer('propertyAmountD');
            $table->integer('propertyAmountE');
            $table->integer('propertyAmountF');
            $table->integer('propertyAmountG');
            $table->integer('propertyAmountH');
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