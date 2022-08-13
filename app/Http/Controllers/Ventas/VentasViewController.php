<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentasViewController extends Controller
{
    public function index()
    {
        $vista = 'ver_ventas_cliente';
        $proforma = 'cliente';
       // $tipo = 'contado';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;

        //return view ('ventas.index',compact('tipo'));

        if($usuario_auth->limitacion == '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('ventas.view_ventas_clientes',compact('sucursal'));
    }

    public function view($sucursal)
    {
       
        return view('ventas.view_ventas_clientes',compact('sucursal'));
    }
}
