<?php

namespace App\Http\Controllers\Ventas;

use App\Http\Controllers\Controller;
use App\Models\MovimientoCaja;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista = 'ventas';
        $proforma = 'venta';
        $usuario_auth = User::where('id',Auth::id())->first();

   


        if($usuario_auth->apertura == 'no'){
            return view('ventas.sin_apertura');
        }
        else{

            $movimiento = MovimientoCaja::where('tipo_movimiento','4')
            ->where('user_id',$usuario_auth->id)
            ->firstOrFail();

            $sucursal = $movimiento->sucursal_id;
            $caja = $movimiento->caja_id;

            return view('ventas.seleccion_producto',compact('sucursal','proforma','caja'));
        }

    }



    public function facturacion($sucursal)
    {
        return view('ventas.facturacion',compact('sucursal'));
    }

  
    public function show($sucursal)
    {
        return view('ventas.cart',compact('sucursal'));
    }


    public function edit($sucursal,$proforma)
    {

        return view('ventas.seleccion_producto',compact('sucursal','proforma'));
    }

  
}
