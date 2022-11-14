<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MostrarVentasController extends Controller
{
    public function index()
    {
        
        $vista = 'ver_ventas';
        $proforma = 'contado';
        $tipo = 'contado';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;
        $sucursales_count = Sucursal::all()->count();

        //dd( $sucursales_count);

        if($usuario_auth->limitacion == '1'){
            if($sucursales_count > '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
            else return view('ventas.index',compact('sucursal','tipo'));
        } 
        else{
            return view('ventas.index',compact('sucursal','tipo'));
        } 
    }

  
    public function create()
    {
        $vista = 'ver_ventas';
        $proforma = 'credito';
        $tipo = 'credito';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;
        $sucursales_count = Sucursal::all()->count();

        //return view ('ventas.index',compact('tipo'));

        /*if($usuario_auth->limitacion == '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('ventas.index',compact('sucursal','tipo'));*/

        if($usuario_auth->limitacion == '1'){
            if($sucursales_count > '1') return view('ventas.seleccion_sucursal',compact('vista','proforma'));
            else return view('ventas.index',compact('sucursal','tipo'));
        } 
        else{
            return view('ventas.index',compact('sucursal','tipo'));
        } 
    }

    public function store(Request $request)
    {

       
    }

  
    public function show($tipo)
    {
       
    }

 
    public function edit($sucursal,$tipo)
    {
        return view ('ventas.index',compact('sucursal','tipo'));
    }

   
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
