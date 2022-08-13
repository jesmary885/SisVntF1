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
            'nombre_encargado' => 'Juan Perez',
            'nombre_proveedor' => 'vj c.a',
            'tipo_documento' => 'ci',
            'nro_documento' => '444444',
            'email' => 'vj@gmail.com',
            'telefono' => '555555',
            'direccion' => 'av. siempre vivas',
            'ciudad_id' => '1',
            'estado_id' => '1',
        ]);
    }
}
