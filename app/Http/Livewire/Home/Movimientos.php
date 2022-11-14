<?php

namespace App\Http\Livewire\Home;

use App\Models\Empresa;
use App\Models\Moneda;
use App\Models\MovimientoCaja;
use App\Models\tasa_dia;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class Movimientos extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $tasa_dia,$moneda_nombre,$moneda_simbolo;

    protected $listeners = ['render' => 'render'];

    public function updatingSearch(){
        $this->resetPage();
    }
   
    public function render()
    {
        if(session()->has('moneda')){
            $this->moneda = Moneda::where('nombre',session('moneda'))->first();
            $this->moneda_nombre = session('moneda');
            $this->moneda_simbolo = session('simbolo_moneda');
            if(session('moneda') == "Bolivar") $this->tasa_dia = 1;
            else $this->tasa_dia = tasa_dia::where('moneda_id',$this->moneda->id)->first()->tasa;
        } 
        else{
            $this->moneda = Moneda::where('nombre','Bolivar')->first();
            $this->moneda_nombre = 'Bolivar';
            $this->moneda_simbolo = 'Bs';
            $this->tasa_dia = 1;
        } 

        $usuario_auth = auth()->user();
        $fecha_actual = date("Y-m-d h:i:s");


        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

        if($usuario_auth->apertura == "si"){
            $fecha_apertura = $usuario_auth->ultima_fecha_apertura;
            $fecha_cierre = $usuario_auth->ultima_fecha_cierre;
            $caja_apertura = $usuario_auth->ultima_caja_id_apertura;
            $sucursal_apertura = $usuario_auth->ultima_sucursal_id_apertura;

            $movimientos= MovimientoCaja::whereBetween('created_at',[$fecha_apertura ,$fecha_actual])
                ->whereBetween('tipo_movimiento',[1,2])
                ->where('sucursal_id',$sucursal_apertura)
                ->where('caja_id',$caja_apertura)
                ->paginate(10);

            if($movimientos->count() > 0) $movimientos=$movimientos;
            else $movimientos = 0;
            
        }

        else{
            $movimientos = 0;
        }

        

        return view('livewire.home.movimientos',compact('movimientos','usuario_ac'));
    }

    public function export_pdf(){

        $usuario_auth = auth()->user();
        $fecha_actual = date("Y-m-d h:i:s");
        $fecha = date('d-m-Y h:i:s');
        $empresa = Empresa::first();

        $fecha_apertura = $usuario_auth->ultima_fecha_apertura;
        $caja_apertura = $usuario_auth->ultima_caja_id_apertura;

        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;
        $sucursal_apertura = $usuario_auth->ultima_sucursal_id_apertura;

        /*$movimientos = MovimientoCaja::where('fecha',$fecha_actual)
            ->where('sucursal_id',$sucursal_act)
            ->where('estado','entregado')
            ->get();*/

        $movimientos= MovimientoCaja::whereBetween('created_at',[$fecha_apertura ,$fecha_actual])
            ->whereBetween('tipo_movimiento',[1,2])
            ->where('sucursal_id',$sucursal_apertura)
            ->where('caja_id',$caja_apertura)
            ->get();

        $data = [
            'movimientos' => $movimientos,
            'sucursal' =>$usuario_ac,
            'fecha' =>$fecha,
            'empresa' => $empresa,
        ];

        $pdf = PDF::loadView('Movimientos_caja.home',$data)->output();

        return response()->streamDownload(
            fn () => print($pdf),
           "Movimientos_del_dia.pdf"
            );

    }


}
