<?php

namespace App\Imports;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ComprasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $usuarios,$sucursals,$proveedors,$productos;

    public function __construct()
    {
        $this->proveedors = Proveedor::pluck('id','nombre_proveedor');
        $this->usuarios = User::pluck('id','email');
        $this->sucursals = Sucursal::pluck('id','nombre');
        $this->productos = Producto::pluck('id','cod_barra');
    }
 
    public function model(array $row)
    {
          Compra::create([
            'fecha'  => $row['fecha'],
            'total' => $row['total'],
            'cantidad'    => $row['cantidad'],
            'precio_compra'    => $row['precio_compra'],
            'proveedor_id' => $this->proveedors[$row['proveedor']],
            'producto_id' => $this->productos[$row['producto']],
            'user_id' => $this->usuarios[$row['usuario']],
            'sucursal_id' => $this->sucursals[$row['sucursal']],
            
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}