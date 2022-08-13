<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class KardexExport implements FromView
{
    protected $fecha_inicio,$movimientos_totales;
    
    public function __construct($movimientos_totales,$fecha_inicio,$fecha_fin)
    {
        $this->movimientos_totales = $movimientos_totales;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;

    }

   public function view(): View
   {


       
       return view('exportexcel.kardex', ['movimientos'=> $this->movimientos_totales,'fecha_inicio' => $this->fecha_inicio,'fecha_fin' => $this->fecha_fin]);
   }
}
