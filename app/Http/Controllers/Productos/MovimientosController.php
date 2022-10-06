<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientosController extends Controller
{
    public function index_recibir()
    {
        $vista = 'productos_recibir';
        $proforma = 'traslado_recibir';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;

        if($usuario_auth->limitacion == '1')  return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('productos.traslado_select_serial',compact('sucursal'));

    }

    public function index_enviar()
    {
        $vista = 'productos_enviar';
        $proforma = 'traslado_enviar';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;

        if($usuario_auth->limitacion == '1')  return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else return view('productos.traslado_select_serial_enviar',compact('sucursal'));

    }

    public function select_modalidad()
    {
        return view('productos.movimientos');
    }

    public function buscar(Request $request)
    {

        $request->validate([
            'modalidad' => 'required'
        ]);

        //$tiporeporte = $request["categoria"];

        if($request["modalidad"]==1){
            return redirect()->route('movimientos.historial');
        }
        if($request["modalidad"]==2){
            return redirect()->route('movimientos.historial_prod_serial');
        }
    
    }

    //historial
    
    public function historial()
    {
        return view('productos.historial');
    }

    public function historial_prod_serial()
    {
        return view('productos.historial_prod_serial');
    }

    public function historial_detalle($vista,$producto,$fecha_inicio,$fecha_fin)
    {
        return view('productos.historial_detalle',compact('vista','producto','fecha_inicio','fecha_fin'));
    }

    //Devolución 

    public function devolucion()
    {
        return view('productos.devolucion');
    }

    public function devolucion_create()
    {
        return view('productos.devolucion_create');
    }

   

    //Traslado

    public function select($sucursal)
    {
       // return view('productos.traslado',compact('sucursal'));
        return view('productos.traslado_select_serial',compact('sucursal'));
    }

    public function select_enviar($sucursal)
    {
       // return view('productos.traslado',compact('sucursal'));
        return view('productos.traslado_select_serial_enviar',compact('sucursal'));
    }

    public function select_serial($sucursal,$producto)
    {
        return view('productos.traslado_select_serial',compact('sucursal','producto'));
    }

    //mostrar ventas

    public function mostrar_ventas($sucursal,$tipo)
    {
        return view('ventas.index',compact('sucursal','tipo'));
    }

    //Productos por lotes

    public function productos_lotes(){
        return view('productos.lotes.index');
    }
}
