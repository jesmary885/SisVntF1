<?php

namespace Database\Seeders;

use App\Models\ProductoSerialSucursal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('productos');
        Storage::makeDirectory('productos');
        $this->call(EstadoSeeder::class);
        $this->call(CiudadSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SucursalSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(MarcaSeeder::class);
        $this->call(ModeloSeeder::class);
        $this->call(ProveedorSeeder::class);
        $this->call(ProductoSeeder::class);
       // $this->call(CompraSeeder::class);
       //$this->call(ProductoSerialSucursalSeeder::class);
        $this->call(ProductoSucursalSeeder::class);
        $this->call(ClienteSeeder::class);
        $this->call(EmpresaSeeder::class);

       
    }
}
