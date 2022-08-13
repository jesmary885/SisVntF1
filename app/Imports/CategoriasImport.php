<?php

namespace App\Imports;

use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
   
    public function model(array $row)
    {
            return new Categoria([
            'nombre'  => $row['nombre'],
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
