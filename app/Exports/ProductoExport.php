<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ProductoExport implements FromView
{
 protected $array,$relacion,$sucursal,$fecha_actual,$vista;
    
     public function __construct($array,$relacion,$sucursal,$vista)
     {
         $this->array = $array;
         $this->relacion = $relacion;
         $this->sucursal = $sucursal;
         $this->vista = $vista;
         $this->fecha_actual = date('d-m-Y');

         

        // dd($this->sucursal);
     }

    public function view(): View
	{
        if($this->vista == 'barra') return view('exportexcel.productos', ['productos'=> $this->array,'relacion' => $this->relacion,'sucursal' => $this->sucursal,'fecha_actual' => $this->fecha_actual]);
        else return view('exportexcel.productos_serial', ['productos'=> $this->array,'relacion' => $this->relacion,'sucursal' => $this->sucursal,'fecha_actual' => $this->fecha_actual]);
	}
}
