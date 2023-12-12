<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualificationsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifications_users', function (Blueprint $table) {
            $table->id('idQualificationUser');
            $table->integer('ratingCleaning');
            $table->integer('ratingPunctuality');
            $table->integer('ratingComunication');
            $table->integer('qualificationAmount');

            $table->unsignedBigInteger('idUser');
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
        Schema::dropIfExists('qualifications_users');
    }
}
