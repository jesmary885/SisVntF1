<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Moneda;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\tasa_dia;
use App\Models\Venta;
use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator; 
use Session;


class HomeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $usuario_auth = auth()->user();
        $logo = Empresa::first()->logo;

        $user_auth =  auth()->user();

        if($user_auth->apertura == 'si'){
            $aperturo = 'si';
        } 
        else{
            $aperturo = 'no';
        } 

        if(session()->has('moneda')){
            $moneda = Moneda::where('nombre',session('moneda'))->first();
            $moneda_nombre = session('moneda');
            $moneda_simbolo = session('simbolo_moneda');
            if(session('moneda') == "Bolivar") $tasa_dia = 1;
            else $tasa_dia = tasa_dia::where('moneda_id',$moneda->id)->first()->tasa;
        } 
        else{
            $moneda = Moneda::where('nombre','Bolivar')->first();
            $moneda_nombre = 'Bolivar';
            $moneda_simbolo = 'Bs';
            $tasa_dia = 1;
        } 

        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

        $fecha_actual = date('Y-m-d');
        $productos_cant = Producto::count();
        $clientes_cant = Cliente::count();
        $fecha_add_mes= date("Y-m-d",strtotime($fecha_actual."+ 1 month"));

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

        $productos_agotar = Producto::where('estado','Habilitado')
            ->whereColumn('cantidad','<=', 'stock_minimo')
            ->count();

        $productos_vencer_encode = DB::select('SELECT COUNT(*) as cantidad from productos p
        inner join producto_lotes pl on p.id=pl.producto_id AND pl.fecha_vencimiento <= :fecha_add_mes
        where p.vencimiento = "Si"'
        ,array('fecha_add_mes' => $fecha_add_mes));

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

        $productos_vencer_decode=json_encode($productos_vencer_encode);
        $productos_vencer_total=json_decode($productos_vencer_decode);

        $traslados_pendiente=json_encode($traslados_pendientes);
        $traslado_pendient=json_decode($traslados_pendiente);
    
        $total_vent=json_encode($total_ventas);
        $total_venta=json_decode($total_vent);
            
        $ventas_totales_dia=$ventas_dia_total[0]->cantidad;
        $total_ganancias_dia=$total_venta[0]->quantity;
        $total_traslados_pendientes =$traslado_pendient[0]->cantidad;
        $productos_vencer=$productos_vencer_total[0]->cantidad;

        return view('home',compact('aperturo','ventas','movimientos','tasa_dia','moneda_simbolo','total_movimientos_pendientes','usuario_ac','productos_cant','clientes_cant','ventas_totales_dia','total_ganancias_dia','total_traslados_pendientes','logo','productos_agotar','productos_vencer'));
    }
}
