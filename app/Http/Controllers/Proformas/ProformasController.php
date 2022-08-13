<?php

namespace App\Http\Controllers\Proformas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProformasController extends Controller
{
    public function index(){
        $vista = 'ventas';
        $proforma= 'proforma';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;
       

        if($usuario_auth->limitacion == '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('ventas.seleccion_producto',compact('sucursal','proforma'));
    }

    public function view(){

            return view('proformas.view');
        
    }

    
    public function seleccio($sucursal,$proforma)
    {

        return view('ventas.seleccion_producto',compact('sucursal','proforma'));
    }

}
