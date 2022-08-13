<?php

namespace App\Imports;

use App\Models\Marca;
use App\Models\Modelo;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ModelosImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $marcas;

    public function __construct()
    {
    
        $this->marcas = Marca::pluck('id','nombre');
      
    }
    public function model(array $row)
    {
            Modelo::create([
            'nombre'  => $row['nombre'],
            'marca_id' => $this->marcas[$row['marca']],
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
