<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Producto_sucursal;
use Illuminate\Database\Seeder;

class ProductoSucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productos = Producto::all();

             foreach ($productos as $producto){
                $producto->sucursals()->attach([
                    1 => [
                        'cantidad' => 25
                    ],
                    2 => [
                        'cantidad' => 25
                    ],
                    3 => [
                        'cantidad' => 0
                    ],
                ]);
             }
    }
}
