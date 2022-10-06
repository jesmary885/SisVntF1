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
            'apellido' => 'N/A',
            'email' => 'na@na.com',
            'nro_documento' => 'N/A',
            'tipo_documento' => 'N/A',
            'telefono' => 'N/A',
            'direccion' => 'N/A',
            'ciudad_id' => '1',
            'user_id' => '1',
            'estado_id' => '1',
            //'puntos' => '8',
        ]);

        Cliente::create([
            'nombre' => 'Pablo',
            'apellido' => 'Perez',
            'email' => 'pablo@gmail.com',
            'nro_documento' => '12345678',
            'tipo_documento' => '1',
            'telefono' => '04152668777',
            'direccion' => 'Avenida francisco de miranda calle 84',
            'ciudad_id' => '1',
            'estado_id' => '1',
            'user_id' => '1',
            //'puntos' => '11',
        ]);

        Cliente::create([
            'nombre' => 'Patria',
            'apellido' => 'Perez',
            'email' => 'patricia@gmail.com',
            'nro_documento' => '12345855',
            'tipo_documento' => '1',
            'telefono' => '0415266877',
            'direccion' => 'Avenida francisco de miranda calle 8',
            'ciudad_id' => '1',
            'estado_id' => '1',
            'user_id' => '1',
            //'puntos' => '5',
        ]);

        Cliente::create([
            'nombre' => 'Pedro',
            'apellido' => 'Perez',
            'email' => 'pedro@gmail.com',
            'nro_documento' => '12345',
            'tipo_documento' => '1',
            'telefono' => '041526687447',
            'direccion' => 'Avenida francisco de miranda calle 8',
            'ciudad_id' => '1',
            'user_id' => '1',
            'estado_id' => '1',
            //'puntos' => '8',
        ]);
        
    }
}

