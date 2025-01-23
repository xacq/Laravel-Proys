<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {    //SE DEFINE EL CAMPO CON LA CONFIGURACION SOLICITADA
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number', 15)->unique()->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {    //SE GENERA LA CREACION DE LA NUEVA COLUMNA CON EL CAMPO CONFIGURADO
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_number');
        });
    }
};
