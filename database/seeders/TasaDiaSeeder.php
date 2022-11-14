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
            'tasa' => '1',
            'user_id' => 1,
            'moneda_id' => 1
        ]);

        tasa_dia::create([
            'tasa' => '6.20',
            'user_id' => 1,
            'moneda_id' => 2
        ]);

        tasa_dia::create([
            'tasa' => '7',
            'user_id' => 1,
            'moneda_id' => 3
        ]);

        tasa_dia::create([
            'tasa' => '4.5',
            'user_id' => 1,
            'moneda_id' => 4
        ]);
    }
}
