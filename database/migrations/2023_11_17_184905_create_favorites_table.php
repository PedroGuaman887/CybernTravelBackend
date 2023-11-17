<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id('idFavorites');
            $table->date('dateSaved');
            $table->unsignedBigInteger('property_id'); 
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('idUser')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('favorites');
    }
}
