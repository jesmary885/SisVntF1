<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    public function facturacion($sucursal,$proforma)
    {
        return view('ventas.facturacion',compact('sucursal','proforma'));
    }
}
