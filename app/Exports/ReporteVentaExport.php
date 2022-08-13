<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReporteVentaExport implements FromView
{
    protected $ventas_realizadas,$total_ventas,$total_costos,$total_ganancias,$fecha_inicio,$fecha_fin;
    
     public function __construct($ventas_realizadas,$total_ventas,$total_costos,$total_ganancias,$fecha_inicio,$fecha_fin)
     {
         $this->ventas_realizadas = $ventas_realizadas;
         $this->total_ventas = $total_ventas;
         $this->total_costos = $total_costos;
         $this->total_ganancias = $total_ganancias;
         $this->fecha_inicio = $fecha_inicio;
         $this->fecha_fin = $fecha_fin ;
     }

    public function view(): View
	{
		return view('exportexcel.reporte_ventas', ['ventas_realizadas'=> $this->ventas_realizadas,'total_ventas' => $this->total_ventas,'total_costos' => $this->total_costos,'total_ganancias' => $this->total_ganancias, 'fecha_inicio' => $this->fecha_inicio, 'fecha_fin' => $this->fecha_fin]);
	}
}
