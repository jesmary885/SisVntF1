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
            'nombre' => 'Tu negocio',
            'email' => 'tunegocio@gmail.com',
            'telefono' => '04555555555',
            'direccion' => 'av. Venezuela',
            'tipo_documento' => 'Rif',
            'nro_documento' => '20603739176',
            'nombre_impuesto' => 'IVA',
            'impuesto' => '18',
            'logo' => 'vendor/adminlte/dist/img/logo.png'
        ]);
    }
}
