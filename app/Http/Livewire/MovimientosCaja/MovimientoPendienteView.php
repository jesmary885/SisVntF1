<?php

namespace App\Http\Livewire\MovimientosCaja;

use App\Models\MovimientoCaja;
use App\Models\Sucursal;
use DateTime;
use Livewire\Component;
use Livewire\WithPagination;

class MovimientoPendienteView extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$sucursal,$movimiento;

    public function updatingSearch(){
        $this->resetPage();
    }
   

    public function render()
    {
        $movimientos = MovimientoCaja::where('sucursal_id', $this->sucursal)
                                        ->where('estado','pendiente')
            ->latest('id')
            ->paginate(5);

        return view('livewire.movimientos-caja.movimiento-pendiente-view',compact('movimientos'));
    }

    public function recibir($movimientoID){
        $this->movimiento = MovimientoCaja::where('id',$movimientoID)->first();
       
       // $busqueda = Producto_venta::where('producto_id',$productoId)->first();


        $this->emit('confirm', 'Esta seguro que recibio el dinero en la caja de su sucursal?','movimientos-caja.movimiento-pendiente-view','confirmacion','El dinero ha sido registrado en la caja de su sucursal');
    }

    public function confirmacion(){

        //$objecto = new DateTime();203250
        $fecha_hora = date('Y-m-d');
        $usuario_auth = auth()->user();
        $usuario_auth_nombre = auth()->user()->name;
        $usuario_auth_apellido = auth()->user()->apellido;

        //dd($this->movimiento->sucursal_id);

        $caja_final= Sucursal::where('id',$this->movimiento->sucursal_id)->first();
        $caja_actual = Sucursal::where('id',$this->movimiento->observacion)->first();

        $movimiento_n = new MovimientoCaja();
        $movimiento_n->fecha = $fecha_hora;
        $movimiento_n->tipo_movimiento = 3;
        $movimiento_n->cantidad = $this->movimiento->cantidad;
        $movimiento_n->observacion = 'Transferencia emitidia desde '. $caja_actual->nombre . ' hasta caja '. $caja_final->nombre . ' Usuario que recibe y confirma ' . $usuario_auth_nombre. ' '. $usuario_auth_apellido;
        $movimiento_n->user_id = $this->movimiento->user_id;
        $movimiento_n->sucursal_id = $this->movimiento->observacion;
        $movimiento_n->estado = 'entregado';
        $movimiento_n->save();
        

        $this->movimiento->update([
            'fecha' => $fecha_hora,
            'tipo_movimiento' => 3,
            'cantidad' => $this->movimiento->cantidad,
            'observacion' => 'Transferencia emitida desde '. $caja_actual->nombre . ' hasta caja '. $caja_final->nombre . ' Usuario que recibe y confirma ' . $usuario_auth_nombre. ' '. $usuario_auth_apellido, //caja inicial
            'user_id' => $usuario_auth->id,
            'sucursal_id' => $caja_final->id, //caja final
            'estado' => 'entregado',

        ]);

        $saldo_caja_final = $caja_final->saldo;
        $saldo_caja_actual = $caja_actual->saldo;
    
        $caja_actual->update([
                        'saldo' => $saldo_caja_actual - $this->movimiento->cantidad,
        ]);
    
        $caja_final->update([
                    'saldo' => $saldo_caja_final + $this->movimiento->cantidad,
        ]);

     
    }

}
