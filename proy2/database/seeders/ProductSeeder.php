<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop Dell XPS 13',
            'description' => 'Una laptop ultraligera con pantalla de alta resolución.',
            'price' => 1299.99,
            'stock' => 50,
        ]);

        Product::create([
            'name' => 'Smartphone Samsung Galaxy S23',
            'description' => 'El último smartphone insignia de Samsung.',
            'price' => 999.99,
            'stock' => 100,
        ]);

        Product::create([
            'name' => 'Tablet Apple iPad Pro',
            'description' => 'La tablet de alto rendimiento de Apple.',
            'price' => 899.99,
            'stock' => 75,
        ]);

        Product::create([
            'name' => 'Televisor LG OLED 65 pulgadas',
            'description' => 'Un televisor OLED con calidad de imagen excepcional.',
            'price' => 1999.99,
            'stock' => 25,
        ]);

        Product::create([
            'name' => 'Audífonos Sony WH-1000XM5',
            'description' => 'Audífonos inalámbricos con cancelación de ruido.',
            'price' => 349.99,
            'stock' => 120,
        ]);

        Product::create([
            'name' => 'Monitor Curvo Samsung 34 pulgadas',
            'description' => 'Un monitor curvo para una experiencia inmersiva.',
            'price' => 449.99,
            'stock' => 60,
        ]);

        Product::create([
            'name' => 'Impresora HP LaserJet Pro',
            'description' => 'Una impresora láser de alta velocidad.',
            'price' => 249.99,
            'stock' => 80,
         ]);

        Product::create([
            'name' => 'Mouse Logitech MX Master 3S',
            'description' => 'Un mouse ergonómico de alto rendimiento.',
            'price' => 99.99,
            'stock' => 150,
        ]);

        Product::create([
          'name' => 'Cámara Canon EOS Rebel T8i',
          'description' => 'Una cámara DSLR para fotografía profesional.',
          'price' => 799.99,
          'stock' => 40,
        ]);

        Product::create([
          'name' => 'Smartwatch Fitbit Sense 2',
          'description' => 'Un smartwatch con seguimiento de salud y fitness.',
          'price' => 299.99,
          'stock' => 110,
      ]);
    }
}
