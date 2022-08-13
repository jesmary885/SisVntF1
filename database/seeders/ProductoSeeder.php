<?php

namespace Database\Seeders;

use App\Models\Imagen;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::create([
            'nombre' => 'Glass',
          //  'inventario_min' => '5',
            'precio_entrada' => '5',
            'precio_letal' => '8',
            'precio_mayor' => '7',
            'puntos' => '10',
            'cod_barra' => '65622258',
            'estado' => '1',
          //  'presentacion' => '1',
            'observaciones' => 'sin observaciones',
            'categoria_id' => '1',
            'modelo_id' => '1',
            'marca_id' => '1',
        ]);

  

        // Imagen::factory(1)->create([
        //     'imageable_id'=> '1',
        //     'imageable_type'=>Producto::class
        // ]);
    }
}
