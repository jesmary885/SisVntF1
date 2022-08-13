<?php

namespace Database\Seeders;

use App\Models\Empresa;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::create([
            'nombre' => 'techperu',
            'email' => 'techperu@gmail.com',
            'telefono' => '015017327',
            'direccion' => 'av. argentina n 428   galeria mesa redonda stand g112',
            'tipo_documento' => '2',
            'nro_documento' => '20603739176',
            'nombre_impuesto' => 'IVA',
            'impuesto' => '18',
            'porcentaje_puntos' => '5',
            'logo' => 'vendor/adminlte/dist/img/logo.png'
        ]);
    }
}
