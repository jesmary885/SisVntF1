<?php

namespace App\Imports;

use App\Models\ProductoSerialSucursal;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Producto_sucursal;
use App\Models\Sucursal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosSerialSucursalImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $categories,$sucursal,$marcas,$productos;

    public function __construct()
    {
        $this->categories = Categoria::pluck('id','nombre');
        $this->marcas = Marca::pluck('id','nombre');
        $this->modelos = Modelo::pluck('id','nombre');
        $this->sucursal = Sucursal::pluck('id','nombre');
        $this->productos = Producto::pluck('id','cod_barra');
    }
    /**
    
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
          ProductoSerialSucursal::create([
            'fecha_compra' => date('Y-m-d'),
            'compra_id' => $row['compra'],
            'cod_barra'    => $row['codigo_de_barras'],
            'estado'    => 'activo',
            'serial'    => $row['serial'],
            'producto_id' => $this->productos[$row['codigo_de_barras']],
            'categoria_id' => $this->categories[$row['categoria']],
            'modelo_id' => $this->modelos[$row['modelo']],
            'marca_id' => $this->marcas[$row['marca']],
            'sucursal_id' => $this->sucursal[$row['sucursal']],
            
        ]);

    }

  /*  public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            Producto_sucursal::create([
                'producto_id' => $row['id'],
                'sucursal_id' => $this->sucursal[$row['sucursal']],
                'cantidad' => $row['stock'],
            ]);

            $sucursales=Sucursal::where('id','!=',$this->sucursal[$row['sucursal']])->get();

            foreach($sucursales as $sucurs){
                Producto_sucursal::create([
                    'producto_id' => $row['id'],
                    'sucursal_id' => $sucurs->id,
                    'cantidad' => 0,
                ]);
            }
        }
    }*/

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
