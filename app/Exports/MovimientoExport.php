<?php

namespace App\Exports;

use App\Models\Movimiento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class MovimientoExport implements FromView
{
    protected $array,$fecha_inicio,$fecha_fin,$producto_nombre,$producto_cod_barra;
    
     public function __construct($array,$fecha_inicio,$fecha_fin,$producto_nombre,$producto_cod_barra)
     {
         $this->array = $array;
         $this->fecha_inicio = $fecha_inicio;
         $this->fecha_fin = $fecha_fin;
         $this->producto_nombre = $producto_nombre;
         $this->producto_cod_barra = $producto_cod_barra;
   
     }

    public function view(): View
	{
        
		return view('exportexcel.productos_movimientos', ['movimientos'=> $this->array,'fecha_inicio' => $this->fecha_inicio,'fecha_fin' => $this->fecha_fin,'producto_nombre' => $this->producto_nombre, 'producto_cod_barra' => $this->producto_cod_barra]);
	}
}
