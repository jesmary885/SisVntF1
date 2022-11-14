<?php

namespace App\Http\Livewire\Admin\Compras;

use App\Models\Caja;
use App\Models\Compra;
use App\Models\Metodo_pago;
use App\Models\MovimientoCaja;
use App\Models\Pago_venta;
use App\Models\Producto;
use Livewire\Component;
use App\Models\Producto_sucursal as Pivot;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ComprasEdit extends Component
{

    public $isopen = false;
    public $producto, $pivot, $precio_compra, $proveedores, $cantidad, $sucursal_nombre, $sucursal_id = "", $sucursales, $proveedor_id = "",$compra;
    public $limitacion_sucursal = true,$total_pagado_cliente,$metodos, $metodo_id,$cajas,$caja_id;
      
    protected $rules = [
        'total_pagado_cliente' => 'required',
    ];

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function mount(){
        
        $this->metodos = Metodo_pago::all();
        $this->cajas = Caja::all();
     }

    public function render()
    {
        return view('livewire.admin.compras.compras-edit');
    }

   public function update(){
        $rules = $this->rules;
        $this->validate($rules);
        $user_auth =  auth()->user()->id;

        if ($this->total_pagado_cliente < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
            $this->reset(['total_pagado_cliente']);
        }

        elseif($this->total_pagado_cliente > $this->compra->deuda_a_proveedor){
            $this->emit('errorSize','El valor ingresado es mayor que la deuda, intentelo de nuevo');
            $this->reset(['total_pagado_cliente']);
        }

        else{
            $deuda_total = $this->compra->deuda_a_proveedor -  $this->total_pagado_cliente;
    
            $this->compra->update([
                'deuda_a_proveedor' => $deuda_total
            ]);

            //IDENTIFICANDO LA CAJA DE LA SUCURSAL INICIAL
            $caja_detalle = Caja::where('id',$this->caja_id)->first();


            if($this->metodo_id == 3){
                $caja_detalle->update([
                    'saldo_bolivares' => ($caja_detalle->saldo_bolivares - $this->total_pagado_cliente) ,
                ]);
            }

            if($this->metodo_id == 4){
                $caja_detalle->update([
                    'saldo_dolares' => ($caja_detalle->saldo_dolares - $this->total_pagado_cliente),
                ]);
            }

            //REGISTRANDO MOVIMIENTO EN CAJA
            $movimiento = new MovimientoCaja();
            $movimiento->fecha = date('Y-m-d');
            $movimiento->tipo_movimiento = 2;
            $movimiento->cantidad = $this->total_pagado_cliente;
            $movimiento->observacion = 'Abono a deuda de compra de producto';
            $movimiento->user_id = $user_auth;
            $movimiento->sucursal_id = $caja_detalle->sucursal_id;
            $movimiento->estado = 'entregado';
            $movimiento->save();

            $this->reset(['isopen']);
            
            $this->emitTo('admin.compras.compra-index','render');
            
            $this->emit('alert','Pago registrado correctamente');
            $this->reset(['total_pagado_cliente','metodo_id','caja_id']);
        }
    }

}
