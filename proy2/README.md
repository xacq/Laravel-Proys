<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Problema 2

API REST Básica
Problema: Implementa una API REST para gestionar Products . La API debe incluir las siguientes funcionalidades:
1. Crear un producto.
2. Listar todos los productos.
3. Mostrar los detalles de un producto por su ID.

Requisitos:

Los productos deben tener los siguientes campos:
id (autoincremental).
name (string, obligatorio).
description (string, opcional).
price (decimal, obligatorio, mayor a 0).
stock (integer, obligatorio, mayor o igual a 0).
Usa controladores y rutas en Laravel para implementar la API.
Implementa validaciones para los datos de entrada.
Documenta la API usando Swagger (u otra herramienta similar).
Entregables:
Código de las rutas y controladores.
Documentación de la API.
Klicana Laravel DEV: Ejercicio 3
Archivo de exportación de Postman para probar la API.

## SOLUCION

### Paso 1. Generamos el modelo y la migracion para Product con lo que generamos el archivo para migrarlo

php artisan make:model Product -m

   INFO  Model [C:\proy2\app\Models\Product.php] created successfully.
   INFO  Migration [C:\proy2\database\migrations/2025_01_22_233518_create_products_table.php] created successfully.

### Paso 2. Se arregla los otros campos que van para esta tabla en el archivo 2025_01_22_233518_create_products_table.php:

    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 8, 2)->unsigned();
    $table->integer('stock')->unsigned();

### Paso 3. Generamos la migration

php artisan migrate

   INFO  Running migrations.  

  2025_01_22_233518_create_products_table ...................................................................................... 26.00ms DONE

### Paso 5. Se genera el controlador para recursos CRUD

    php artisan make:controller ProductController

INFO  Controller [C:\proy2\app\Http\Controllers\ProductController.php] created successfully.

### Paso 6. Editamos el controlador generado ProductController.php

en index:

        $products = Product::all();
        return response()->json(['data' => $products], Response::HTTP_OK);
        
En store:

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);

En show:

        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product, 200);

### Paso 7. Se edita las rutas en urls

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);

### Paso 8. Se genera la documentación Swagger y la publicamos (considerar no tener antivirus activo en la instalacion)
    
    composer require darkaonline/l5-swagger
    php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
   
INFO  Publishing assets.
Copying file [C:\proy2\vendor\darkaonline\l5-swagger\config\l5-swagger.php] to [C:\proy2\config\l5-swagger.php] ................ DONE
Copying directory [C:\proy2\vendor\darkaonline\l5-swagger\resources\views] to [C:\proy2\resources\views\vendor\l5-swagger] ..... DONE

        php artisan l5-swagger:generate
        composer require zircote/swagger-php

Debido a actualizacion de Laravel, ahora ya no genera automaticamente el api.php sino que hay que gestionarlo a traves de la instruccion 

    php artisan install:api

Solo asi se registra esta ruta y puede funcionar la visualizacion de la informacion desde la base de datos al API

### Paso 9. Se revisa la documentacion en la direccion localhost/api/documentation al ejecutar la aplicacion

Creamos un seeder para poner informacion en la tabla products

    php artisan make:seeder ProductSeeder
- Editamos el seeder con el formato
  
        Product::create([
        'name' => 'Cámara Canon EOS Rebel T8i',
        'description' => 'Una cámara DSLR para fotografía profesional.',
        'price' => 799.99,
        'stock' => 40,
        ]);
  
- php artisan db:seed --class=ProductSeeder
- probamos corriendo la aplicacion con el servidor php artisan serve bajo la direccion 
    http://127.0.0.1:8000/api/documentation (en localhost)

### Paso 10. Importar el archivo formato postman para probar API que se encuentra en la carpeta principal

- Product API.postman_collection.json
