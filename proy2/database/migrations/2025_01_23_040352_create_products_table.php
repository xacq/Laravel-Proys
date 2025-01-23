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
    {    //SE AUMENTO LOS CAMPOS A PARTE DE ID Y TIMESTAMP QUE YA SE GENEREAN AUTOMATICAMENTE
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //NOMBRE DEL PRODUCTO
            $table->text('description')->nullable(); //TEXTO DESCRIPTIVO DEL PRODUCTO
            $table->decimal('price', 10, 2); //PRECIO DEL PRODUCTO
            $table->integer('stock'); //STOCK DEL PRODUCTO
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
