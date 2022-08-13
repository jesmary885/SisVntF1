<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Marca;


class MarcasImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
   
    public function model(array $row)
    {
            Marca::create([
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
