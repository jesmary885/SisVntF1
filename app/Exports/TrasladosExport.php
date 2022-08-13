<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TrasladosExport implements FromView
{
    protected $array,$fecha_inicio,$fecha_fin;
    
    public function __construct($array,$fecha_inicio,$fecha_fin)
    {
        $this->array = $array;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
  
    }

   public function view(): View
   {    
       return view('exportexcel.traslados', ['traslados'=> $this->array,'fecha_inicio' => $this->fecha_inicio,'fecha_fin' => $this->fecha_fin]);
   }
}


