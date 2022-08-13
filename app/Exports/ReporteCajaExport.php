<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReporteCajaExport implements FromView
{
    protected $movimientos,$fecha_inicio,$fecha_fin;
    
     public function __construct($movimientos,$fecha_inicio,$fecha_fin)
     {
         $this->movimientos = $movimientos;
         $this->fecha_inicio = $fecha_inicio;
         $this->fecha_fin = $fecha_fin ;
     }

     public function view(): View
     {
         return view('exportexcel.reporte_cajas', ['movimientos'=> $this->movimientos,'fecha_inicio' => $this->fecha_inicio, 'fecha_fin' => $this->fecha_fin]);
     }

}

