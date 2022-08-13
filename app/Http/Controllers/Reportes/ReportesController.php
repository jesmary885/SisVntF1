<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportesController extends Controller
{

    public function index_producto(){
        $vista='productos';
        return view('reportes.index',compact('vista'));
    }

    public function index_venta(){
        $vista = 'ventas';
        return view('reportes.index',compact('vista'));
    }

    public function index_caja(){
        $vista = 'cajas';
        return view('reportes.index',compact('vista'));
    }

    public function index_traslados(){
        $vista = 'traslados';
        return view('reportes.index-traslados',compact('vista'));
    }

    public function index_kardex(){
        $vista = 'kardex';
        return view('reportes.index-traslados',compact('vista'));
    }

    public function index_desactivados(){
    
        return view('reportes.index-desactivados');
    }


    public function productos($sucursal_id,$fecha_inicio,$fecha_fin)
    {
        return view('reportes.productos',compact('sucursal_id','fecha_inicio','fecha_fin'));
    }

    
    public function cajas($sucursal_id,$fecha_inicio,$fecha_fin)
    {
        return view('reportes.cajas',compact('sucursal_id','fecha_inicio','fecha_fin'));
    }

    public function ventas($sucursal_id,$fecha_inicio,$fecha_fin)
    {
        return view('reportes.ventas',compact('sucursal_id','fecha_inicio','fecha_fin'));
    }

    public function traslados($fecha_inicio,$fecha_fin)
    {
        return view('reportes.traslados',compact('fecha_inicio','fecha_fin'));
    }

    
    public function kardex($fecha_inicio,$fecha_fin)
    {
        return view('reportes.kardex',compact('fecha_inicio','fecha_fin'));
    }

}
