<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Producto_lote;
use App\Models\Producto_sucursal;
use App\Models\Proveedor;
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
        $this->proveedores = Proveedor::pluck('id','nombre_proveedor');
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
            'cod_barra'    => $row['codigo_de_barras'],
            'cantidad'    => $row['cantidad'],
            'estado'    => 'Habilitado',
            'categoria_id' => $this->categories[$row['categoria']],
            'modelo_id' => $this->modelos[$row['modelo']],
            'marca_id' => $this->marcas[$row['marca']],
            'presentacion'    => $row['presentacion'],
            'tipo_garantia'    => $row['tipo_de_garantia'],
            'stock_minimo'    => $row['stock_minimo'],
            'descuento'    => $row['descuento'],
            'vencimiento'    => $row['vencimiento'],
            'exento'    => $row['exento'],
            'unidad_tiempo_garantia'    => $row['unidad_de_tiempo_de_garantia'],
        ]);

        Producto_lote::create([
            'lote'  => 1,
            'producto_id' => $producto->id,
            'precio_entrada' => $row['precio_de_compra'],
            'precio_letal'    => $row['precio_venta_detal'],
            'precio_mayor'    => $row['precio_venta_mayor'],
            'precio_combo'    => $row['precio_venta_combo'],
            'utilidad_letal'    => $row['utilidad_al_detal'],
            'utilidad_mayor'    => $row['utilidad_al_mayor'],
            'utilidad_combo'    => $row['utilidad_por_combo'],
            'margen_letal'    => $row['margen_al_detal'],
            'margen_mayor'    => $row['margen_al_mayor'],
            'margen_combo'    => $row['margen_por_combo'],
            'proveedor_id' => $this->proveedores[$row['proveedor']],
            'stock'    => $row['cantidad'],
            'fecha_vencimiento'    => $row['fecha_de_vencimiento'],
            'status'    => 'activo',
            'observaciones'    => 'Sin observaciones',
        ]);

        $fecha_actual = date('Y-m-d');
        $total = $row['precio_de_compra'] * $row['cantidad'];
        $deuda = ($row['precio_de_compra'] * $row['cantidad']) - $row['pago_a_proveedor'];

        Compra::create([
            'fecha'  => $fecha_actual ,
            'total' => $total,
            'cantidad' => $row['cantidad'],
            'precio_compra'    => $row['precio_de_compra'],
            'deuda_a_proveedor'    => $deuda,
            'proveedor_id'    => $this->proveedores[$row['proveedor']],
            'producto_id'    => $producto->id,
            'user_id'    => 1,
            'sucursal_id'  => 1,
            'lote' => 1
        ]);

        $sucursales=Sucursal::all();

            foreach($sucursales as $sucurs){
                $nombre = $sucurs->nombre;
                $nombre_separada = str_replace(" ","_",$nombre);
                $nombre_final = strtolower($nombre_separada);

                Producto_sucursal::create([
                    'producto_id' => $producto->id,
                    'lote' => 1,
                    'sucursal_id' => $sucurs->id,
                    'cantidad' => $row[$nombre_final],
                    'status' => 'activo',
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
