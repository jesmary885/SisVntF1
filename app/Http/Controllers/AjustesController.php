<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjustesController extends Controller
{
    public function ccontrasena()
    {
        return view('CambiarContrasena');
    }
    public function empresa()
    {
        return view('SobreEmpresa');
    }
    public function moneda()
    {
        return view('CambiarMoneda');
    }
    public function aperturaCaja()
    {
        return view('AperturaCaja');
    }
    public function cuentasPagar()
    {
        return view('CuentasPagar');
    }
    public function cuentasCobrar()
    {
        return view('CuentasCobrar');
    }
}
