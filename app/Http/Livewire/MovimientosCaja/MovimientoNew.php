<?php

namespace App\Http\Livewire\MovimientosCaja;

use App\Models\MovimientoCaja;
use App\Models\Sucursal;
use DateTime;
use Livewire\Component;

class MovimientoNew extends Component
{

    public $sucursales, $sucursal, $tipo_movimiento, $cantidad, $observaciones, $sucursal_id = "";
    public $isopen = false;

      
    protected $rules = [
        'tipo_movimiento' => 'required',
        'cantidad' => 'required',
        'observaciones' => 'required',
    ];

    protected $rules_t = [
        'tipo_movimiento' => 'required',
        'cantidad' => 'required',
        'observaciones' => 'required',
        'sucursal_id' => 'required',
    ];

    public function mount(){
 
             $this->sucursales=Sucursal::where('id','!=',$this->sucursal)->get();
     }

    public function render()
    {
        return view('livewire.movimientos-caja.movimiento-new');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function save(){
        $fecha_hora = date('Y-m-d');
        $accion = '0';
        $usuario_auth = auth()->user();
        $caja_actual = Sucursal::where('id',$this->sucursal)->first();
        $saldo_caja_actual = $caja_actual->saldo;

        if($this->cantidad >= 0){
            if($this->tipo_movimiento == 3){
                $rules = $this->rules_t;
                $this->validate($rules);
    
                if($saldo_caja_actual > $this->cantidad){
                    $caja_final= Sucursal::where('id',$this->sucursal_id)->first();
                    $movimiento = new MovimientoCaja();
                    $movimiento->fecha = $fecha_hora;
                    $movimiento->tipo_movimiento = 1;
                    $movimiento->cantidad = $this->cantidad;
                    $movimiento->observacion = $caja_actual->id;
                    $movimiento->user_id = $usuario_auth->id;
                    $movimiento->sucursal_id = $caja_final->id;
                    $movimiento->estado = 'pendiente';
                    $movimiento->save();
                    $accion = '0';
                    $this->reset(['isopen','cantidad','sucursal_id','tipo_movimiento','observaciones']);
                    $this->emitTo('movimientos-caja.movimiento-view','render');
                    $this->emit('alert','La sucursal destino debe confirmar que ha recibido el dinero para registrar el movimiento');
                }
                else{
                    $this->emit('errorSize', 'Fondos insuficientes para la transferencia de dinero');
                }
            }
            else{
                $rules = $this->rules;
                $this->validate($rules);
                if($this->tipo_movimiento == 1){
                    $caja_actual->update([
                        'saldo' => $saldo_caja_actual + $this->cantidad,
                    ]);
                    $accion = '1';
                }
                else{
                    if($saldo_caja_actual > $this->cantidad){
                        $caja_actual->update([
                            'saldo' => $saldo_caja_actual - $this->cantidad,
                        ]);
                        $accion = '1';
                    }
                    else{
                        $this->emit('errorSize', 'Fondos insuficientes para la transferencia de dinero');
                    }
                }
            }
            if($accion == '1'){
                $movimiento = new MovimientoCaja();
                $movimiento->fecha = $fecha_hora;
                $movimiento->tipo_movimiento = $this->tipo_movimiento;
                $movimiento->cantidad = $this->cantidad;
                $movimiento->observacion = $this->observaciones;
                $movimiento->user_id = $usuario_auth->id;
                $movimiento->sucursal_id = $this->sucursal;
                $movimiento->estado = 'entregado';
                $movimiento->save();
                $this->reset(['isopen','cantidad','sucursal_id','tipo_movimiento','observaciones']);
                $this->emitTo('movimientos-caja.movimiento-view','render');
                $this->emit('alert','Datos registrados correctamente');
            }
        }
    }
}
