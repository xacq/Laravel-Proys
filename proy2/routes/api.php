<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//GENERAMOS 3 RUTAS PARA CADA UNO DE LAS ACCIONES QUE SE VAN A REALIZAR CON EL API
Route::get('/products', [ProductController::class, 'index']); //LISTAR PRODUCTOS
Route::get('/products/{id}', [ProductController::class, 'show']); //OBTENER UN PRODUCTO DESDE EL ID
Route::post('/products', [ProductController::class, 'store']); //CREAR UN PRODUCTO NUEVO A TRAVES DE UN JSON

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
