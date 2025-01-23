<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //Se gestiona la estructura del model de productos
    protected $fillable = ['name', 'description', 'price', 'stock'];
}
