<?php

namespace Database\Seeders;

use App\Models\Compra;
use Illuminate\Database\Seeder;

class CompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Compra::create([
            'fecha' => date('Y-m-d'),
            'total' => '50',
            'precio_compra' => '5',
            'proveedor_id' => '1',
            'producto_id' => '1',
            'cantidad' => '10',
            'user_id' => '1',
            'sucursal_id' => '1',
        ]);

    }
}
