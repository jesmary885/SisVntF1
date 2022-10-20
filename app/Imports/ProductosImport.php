<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Producto_sucursal;
use App\Models\Sucursal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $categories,$sucursal,$marcas;

    public function __construct()
    {
        $this->categories = Categoria::pluck('id','nombre');
        $this->marcas = Marca::pluck('id','nombre');
        $this->modelos = Modelo::pluck('id','nombre');
        $this->sucursal = Sucursal::pluck('id','nombre');
    }
    /**
    
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         $producto = Producto::create([
            'nombre'  => $row['nombre'],
            'precio_entrada' => $row['compra'],
            'precio_letal'    => $row['minorista'],
            'precio_mayor'    => $row['mayorista'],
            'cod_barra'    => $row['codigo_de_barras'],
            'cantidad'    => $row['cantidad'],
            'estado'    => 'Habilitado',
            //'puntos'    => $row['puntos'],
            'observaciones'    => $row['observaciones'],
            'categoria_id' => $this->categories[$row['categoria']],
            'modelo_id' => $this->modelos[$row['modelo']],
            'marca_id' => $this->marcas[$row['marca']],
            
        ]);


      /*  Producto_sucursal::create([
            'producto_id' => $row['id'],
            'sucursal_id' => $this->sucursal[$row['sucursal']],
            'cantidad' => $row['minorista'],
        ]);*/

        $sucursales=Sucursal::all();

            foreach($sucursales as $sucurs){
                $nombre = $sucurs->nombre;
                $nombre_separada = str_replace(" ","_",$nombre);
                $nombre_final = strtolower($nombre_separada);

               // dd($nombre_separada);
                Producto_sucursal::create([
                    'producto_id' => $producto->id,
                    'sucursal_id' => $sucurs->id,
                    'cantidad' => $row[$nombre_final],
                ]);
            }


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
