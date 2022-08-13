<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Venta;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator; 


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      
        $usuario_auth = auth()->user();
        $logo = Empresa::first()->logo;
        //dd($logo);
        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

            $fecha_actual = date('Y-m-d');
            $productos_cant = Producto::count();
            $clientes_cant = Cliente::count();

            $cantidad_ventas = DB::select('SELECT COUNT(*) as cantidad from ventas v
            where v.fecha = :fecha_actual AND v.estado = "activa"' 
            ,array('fecha_actual' => $fecha_actual));

            $total_ventas = DB::select('SELECT sum(v.total_pagado_cliente) as quantity from ventas v
            where v.fecha = :fecha_actual AND v.estado = "activa"'
            ,array('fecha_actual' => $fecha_actual));

            $traslados_pendientes = DB::select('SELECT COUNT(*) as cantidad from productos_traslados pt
            where pt.sucursal_id = :sucursal_usuario' 
            ,array('sucursal_usuario' => $usuario_auth->sucursal_id));

            $movimientos_pendientes = MovimientoCaja::where('sucursal_id',$sucursal_act)
            ->where('estado','pendiente')
            ->get();

            $total_movimientos_pendientes = 0;
            foreach($movimientos_pendientes as $mp){
                $total_movimientos_pendientes++;
            }

            $movimientos = MovimientoCaja::where('fecha',$fecha_actual)
                                            ->where('sucursal_id',$sucursal_act)
                                            ->where('estado','entregado')
                                            ->paginate(5);

            $ventas = Venta::where('fecha', $fecha_actual)
                            ->where('sucursal_id',$sucursal_act)
                            ->where('estado', 'activa')
                            ->paginate(5);
                                                        
            $ventas_dia=json_encode($cantidad_ventas);
            $ventas_dia_total=json_decode($ventas_dia);

            $traslados_pendiente=json_encode($traslados_pendientes);
            $traslado_pendient=json_decode($traslados_pendiente);
    
            $total_vent=json_encode($total_ventas);
            $total_venta=json_decode($total_vent);
            
            $ventas_totales_dia=$ventas_dia_total[0]->cantidad;
            $total_ganancias_dia=$total_venta[0]->quantity;
            $total_traslados_pendientes =$traslado_pendient[0]->cantidad;

            return view('home',compact('ventas','movimientos','total_movimientos_pendientes','usuario_ac','productos_cant','clientes_cant','ventas_totales_dia','total_ganancias_dia','total_traslados_pendientes','logo'));

    }
}
