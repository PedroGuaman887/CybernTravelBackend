<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeyInReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Elimina la restricción de clave externa existente
            $table->dropForeign(['idProperty']);

            // Agrega la nueva restricción con onDelete('cascade')
            $table->foreign('idProperty')->references('idProperty')->on('properties')->onDelete('cascade');
        });
    }

    public function down()
    {
        // En caso de necesitar revertir la migración
        Schema::table('reservations', function (Blueprint $table) {
            // Elimina la restricción de clave externa existente
            $table->dropForeign(['idProperty']);

            // Agrega la restricción original
            $table->foreign('idProperty')->references('idProperty')->on('properties');
        });
    }
}
