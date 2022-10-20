<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Caja;
use App\Models\Metodo_pago;
use App\Models\MovimientoCaja;
use App\Models\Pago_venta;
use App\Models\Sucursal;
use Livewire\Component;

class VentasCreditoAbono extends Component
{
    
    public $venta,$total_pagado_cliente,$metodos, $metodo_id,$cajas,$caja_id,$sucursal;
    public $isopen = false;
    public $vista;

      
    protected $rules = [
        'total_pagado_cliente' => 'required',
    ];


    public function mount(){
        
        $this->metodos = Metodo_pago::all();
        $this->cajas = Caja::where('sucursal_id',$this->sucursal)->get();

    }


    public function render()
    {
        return view('livewire.ventas.ventas-credito-abono');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function update(){
        $rules = $this->rules;
        $this->validate($rules);
        $user_auth =  auth()->user()->id;

        if ($this->total_pagado_cliente < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
            $this->reset(['total_pagado_cliente']);
        }

        elseif($this->total_pagado_cliente > $this->venta->deuda_cliente){
            $this->emit('errorSize','El valor ingresado es mayor que la deuda del cliente, intentelo de nuevo');
            $this->reset(['total_pagado_cliente']);
        }

        else{

            $total_pagado = $this->venta->total_pagado_cliente + $this->total_pagado_cliente;
            $deuda_total = $this->venta->total - $total_pagado;
    
            $this->venta->update([
                'total_pagado_cliente' => $total_pagado,
                'deuda_cliente' => $deuda_total
            ]);

            //IDENTIFICANDO LA CAJA DE LA SUCURSAL INICIAL
            $caja_final= Sucursal::where('id',$this->venta->sucursal_id)->first();
            $caja_detalle = Caja::where('id',$this->caja_id)->first();

            //REGISTRANDO MONTO EN TIPO DE PAGO RECIBIDO
            $pago_venta = new Pago_venta();
            $pago_venta->monto = $this->total_pagado_cliente;
            $pago_venta->metodo_pago_id = $this->metodo_id;
            $pago_venta->venta_id = $this->venta->id;
            $pago_venta->save();

            if($this->metodo_id == 3){
                $caja_detalle->update([
                    'saldo_bolivares' => ($caja_detalle->saldo_bolivares + $this->total_pagado_cliente) ,
                ]);
            }

            if($this->metodo_id == 4){
                $caja_detalle->update([
                    'saldo_dolares' => ($caja_detalle->saldo_dolares + $this->total_pagado_cliente),
                ]);
            }

            //REGISTRANDO MOVIMIENTO EN CAJA
            $movimiento = new MovimientoCaja();
            $movimiento->fecha = date('Y-m-d');
            $movimiento->tipo_movimiento = 1;
            $movimiento->cantidad = $this->total_pagado_cliente;
            $movimiento->observacion = 'Abono de venta a credito';
            $movimiento->user_id = $user_auth;
            $movimiento->sucursal_id = $caja_final->id;
            $movimiento->estado = 'entregado';
            $movimiento->save();

            $this->reset(['isopen']);
            if($this->vista==1){
                $this->emitTo('ventas.ventas-por-cliente','render');
            }else{
                $this->emitTo('ventas.ventas-credito','render');
            }
            $this->emit('alert','Pago registrado correctamente');
            $this->reset(['total_pagado_cliente']);
        }
    }

}
