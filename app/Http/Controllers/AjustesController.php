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
}
