<?php

namespace App\Http\Livewire\Home;

use App\Models\Compra;
use App\Models\Empresa;
use App\Models\Moneda;
use App\Models\tasa_dia;
use App\Models\Venta;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class Ventas extends Component
{
    use WithPagination;

    public $tasa_dia,$moneda_nombre,$moneda_simbolo;

    protected $paginationTheme = "bootstrap";

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
        $fecha_actual = date('Y-m-d');

        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

        $ventas = Venta::where('fecha', $fecha_actual)
        ->where('sucursal_id',$sucursal_act)
        ->where('estado', 'activa')
        ->paginate(5);

        return view('livewire.home.ventas',compact('ventas','usuario_ac'));
    }

    public function export_pdf(){

        $usuario_auth = auth()->user();
        $fecha_actual = date('Y-m-d');
        $fecha = date('d-m-Y');
        $empresa = Empresa::first();

        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

        $compras = Compra::where('fecha', $fecha_actual)
        ->where('sucursal_id',$sucursal_act)
        ->get();

        $compras_total = 0;
        foreach($compras as $comprast){
            $compras_total = $compras_total + $comprast->total;
        }

        $ventas = Venta::where('fecha', $fecha_actual)
        ->where('sucursal_id',$sucursal_act)
        ->where('estado', 'activa')
        ->get();

        $data = [
            'ventas' => $ventas,
            'sucursal' =>$usuario_ac,
            'total_compras' => $compras_total,
            'fecha' =>$fecha,
            'empresa' => $empresa,
        ];

        $pdf = PDF::loadView('ventas.home',$data)->output();

        return response()->streamDownload(
            fn () => print($pdf),
           "Ventas_del_dia.pdf"
            );

    }
}
