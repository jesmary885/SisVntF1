<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::create([
            'nombre' => 'Publico general',
            'apellido' => 'NA',
            'email' => 'na@na.com',
            'nro_documento' => 'NA',
            'tipo_documento' => 'Otro',
            'telefono' => 'NA',
            'direccion' => 'NA',
            'ciudad_id' => '1',
            'user_id' => '1',
            'estado_id' => '1',
            //'puntos' => '8',
        ]);

        
    }
}

