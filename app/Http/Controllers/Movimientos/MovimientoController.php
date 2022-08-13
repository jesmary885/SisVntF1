<?php

namespace App\Http\Controllers\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{

    public function view($sucursal){
        return view('Movimientos_caja.view',compact('sucursal'));
    }

    public function view_pendiente($sucursal){
        return view('Movimientos_caja.view_pendiente',compact('sucursal'));
    }

    public function index(){
        $vista = 'cajas';
        $proforma = 'venta';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;

        if($usuario_auth->limitacion == '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('Movimientos_caja.view',compact('sucursal'));
    }

    /*public function new($sucursal){
        return view('Movimientos_caja.new',compact('sucursal'));
    }*/

    public function index_pendiente(){
        $vista = 'cajas_pendiente';
        $proforma = 'venta';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;

        if($usuario_auth->limitacion == '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('Movimientos_caja.view_pendiente',compact('sucursal'));
    }
}
