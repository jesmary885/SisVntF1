<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::create([
            'nombre_encargado' => 'nombre_prueba',
            'nombre_proveedor' => 'Proveedor prueba c.a',
            'tipo_documento' => 'Rif',
            'nro_documento' => '1111111111',
            'email' => 'prueba@gmail.com',
            'telefono' => '1111111111',
            'direccion' => 'av. prueba',
            'ciudad_id' => '1',
            'estado_id' => '1',
        ]);
    }
}
