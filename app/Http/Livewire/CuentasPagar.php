<?php

namespace App\Http\Livewire;

use App\Models\Compra;
use App\Models\Moneda;
use App\Models\tasa_dia;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class CuentasPagar extends Component
{
    use WithPagination;

    public $tasa_dia,$moneda_nombre,$moneda_simbolo,$total_pdf;
    protected $paginationTheme = "bootstrap";

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

        $cuentas = Compra::where('deuda_a_proveedor', '!=', 0)
            ->paginate(10);
        
        $total_deudas =  DB::select('SELECT sum(c.deuda_a_proveedor) as quantity from compras c
        where c.deuda_a_proveedor != 0');

        $total_encode=json_encode($total_deudas);
        $total_decode = json_decode($total_encode);
        $total = $total_decode[0]->quantity;

        $this->total_pdf = $total; 

        return view('livewire.cuentas-pagar',compact('cuentas','total'));
    }

    public function export_pdf(){
        $fecha_actual = date('d-m-Y');
        $usuario_nombre =  auth()->user()->name;
        $usuario_apellido =  auth()->user()->apellido;

        $cuentas_pdf = Compra::where('deuda_a_proveedor', '!=', 0)
            ->get();

        $data = [
            'cuentas' => $cuentas_pdf,
            'total' => $this->total_pdf,
            'fecha' => $fecha_actual,
            'usuario_nombre' => $usuario_nombre,
            'usuario_apellido' => $usuario_apellido,
            'moneda_simbolo' => $this->moneda_simbolo,
            'tasa_dia' => $this->tasa_dia
        ];

       $pdf = PDF::loadView('reportes.cuentas_pagar',$data)->output();

       return response()->streamDownload(
        fn () => print($pdf),
       "Cuentas por pagar.pdf"
        );
    }
}
