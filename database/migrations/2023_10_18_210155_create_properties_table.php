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
            $table->datetime('propertyStartA')->nullable();
            $table->datetime('propertyEndA')->nullable();
            $table->datetime('propertyStartB')->nullable();
            $table->datetime('propertyEndB')->nullable();
            $table->datetime('propertyStartC')->nullable();
            $table->datetime('propertyEndC')->nullable();
            $table->datetime('propertyStartD')->nullable();
            $table->datetime('propertyEndD')->nullable();
            $table->datetime('propertyStartE')->nullable();
            $table->datetime('propertyEndE')->nullable();
            $table->datetime('propertyStartF')->nullable();
            $table->datetime('propertyEndF')->nullable();
            $table->datetime('propertyStartG')->nullable();
            $table->datetime('propertyEndG')->nullable();
            $table->datetime('propertyStartH')->nullable();
            $table->datetime('propertyEndH')->nullable();
            $table->integer('propertyAmountA')->nullable();
            $table->integer('propertyAmountB')->nullable();
            $table->integer('propertyAmountC')->nullable();
            $table->integer('propertyAmountD')->nullable();
            $table->integer('propertyAmountE')->nullable();
            $table->integer('propertyAmountF')->nullable();
            $table->integer('propertyAmountG')->nullable();
            $table->integer('propertyAmountH')->nullable();
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