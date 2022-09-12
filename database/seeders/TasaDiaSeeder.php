<?php

namespace Database\Seeders;

use App\Models\tasa_dia;
use Illuminate\Database\Seeder;

class TasaDiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tasa_dia::create([
            'tasa' => '6.20',
            'user_id' => 1,
            'moneda' => 'Dolar'
        ]);

        tasa_dia::create([
            'tasa' => '6.36',
            'user_id' => 1,
            'moneda' => 'Euro'
        ]);
    }
}
