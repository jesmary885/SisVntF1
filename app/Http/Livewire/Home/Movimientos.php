<?php

namespace App\Http\Livewire\Home;

use App\Models\Empresa;
use App\Models\MovimientoCaja;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class Movimientos extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render'];

    public function updatingSearch(){
        $this->resetPage();
    }
   
    public function render()
    {
        $usuario_auth = auth()->user();
        $fecha_actual = date('Y-m-d');

        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

        $movimientos = MovimientoCaja::where('fecha',$fecha_actual)
                                            ->where('sucursal_id',$sucursal_act)
                                            ->where('estado','entregado')
                                            ->paginate(5);

        return view('livewire.home.movimientos',compact('movimientos','usuario_ac'));
    }

    public function export_pdf(){

        $usuario_auth = auth()->user();
        $fecha_actual = date('Y-m-d');
        $fecha = date('d-m-Y');
        $empresa = Empresa::first();

        $usuario_ac = $usuario_auth->sucursal->nombre;
        $sucursal_act = $usuario_auth->sucursal->id;

        $movimientos = MovimientoCaja::where('fecha',$fecha_actual)
                                            ->where('sucursal_id',$sucursal_act)
                                            ->where('estado','entregado')
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
