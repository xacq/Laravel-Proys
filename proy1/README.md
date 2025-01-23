<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Problema 1

    Un cliente necesita agregar una nueva columna phone_number a la tabla users .
    Esta columna debe cumplir las siguientes condiciones:
    Tipo: string
    Longitud máxima: 15 caracteres
    Debe ser única.

## SOLUCION 1

### Paso 1. Crear una migración para agregar la columna

php artisan make:migration add_phone_number_to_users_table --table=users

### Paso 2. Revisar el resultado en carpeta database/migrations/ en la creacion del archivo:

2025_01_22_215151_add_phone_number_to_users_table.php

### Paso 3. Añadir las instrucciones para configurar el nuevo campo asi como crear la columna en la tabla

Dentro de la funcion public function up()
    $table->string('phone_number', 15)->unique()->nullable(false);

Dentro de la funcion public function down()
    $table->dropColumn('phone_number');

### Paso 4. Generar el migrate para reflejar en la base de datos

php artisan migrate

Resultado esperado: 
 INFO  Running migrations.  

  2025_01_22_215151_add_phone_number_to_users_table .......................................... 3.48ms DONE

### Paso 5. Configuracion del Controller tanto para creacion y actualizacion del campo extra

Tanto en el store como en el update
$validatedData = $request->validate([
            'phone_number' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/', 'unique:users,phone_number'],
        ]);


### Paso 6. Configuracion del Seeder para tabla users

php artisan make:seeder UsersTableSeeder

### Paso 7. Ejecucion del seeder para llenar la tabla users

php artisan db:seed --class=UsersTableSeeder

* ARCHIVO sql EN LA CARPETA PRINCIPAL
