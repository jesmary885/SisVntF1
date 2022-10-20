<?php

namespace App\Http\Livewire\Productos;

use App\Models\Producto;
use Livewire\Component;

use App\Models\Producto_sucursal as Pivot;
use App\Models\ProductosTraslado;
use App\Models\Sucursal;
use App\Models\Traslado;

class ProductosRecibirUnidad extends Component
{

    public $isopen = false;
    public $sucursal,$producto,$sucursal_id,$quantity,$qty;

    protected $listeners = ['render' => 'render'];

    public function mount(){
        $this->qty = $this->producto->cantidad;
        $this->quantity = $this->producto->cantidad;
    }

    public function decrement(){
        $this->qty = $this->qty - 1;
    }

    public function increment(){
        $this->qty = $this->qty + 1;
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false; 

    }
    public function render()
    {
        return view('livewire.productos.productos-recibir-unidad');
    }

    public function addItem(){

        $fecha_actual = date('Y-m-d');
        $user_auth_nombre =  auth()->user()->name;
        $user_auth_apellido =  auth()->user()->apellido;

        $producto_delete = ProductosTraslado::where('id',$this->producto->id)->first();

        $product = Producto::where('id',$producto_delete->producto_id)->first();

        $product->update([
            'cantidad' => $product->cantidad + $this->qty,
        ]);

        $sucursal = Sucursal::where('id',$producto_delete->sucursal_id)->first();

        $pivot_increment = Pivot::where('sucursal_id', $producto_delete->sucursal_id)
            ->where('producto_id', $producto_delete->producto_id)
            ->where('lote', $producto_delete->lote)
            ->first();
            
        $pivot_increment->cantidad = $pivot_increment->cantidad + $this->qty;
        $pivot_increment->save();

        $traslado_pendiente_delete = Traslado::where('sucursal_origen',$producto_delete->sucursal_origen)
            ->where('sucursal_id',$producto_delete->sucursal_id)
            ->where('producto_id',$producto_delete->producto_id)
            ->where('lote',$producto_delete->lote)
            ->first(); 

        if($producto_delete->cantidad == $this->qty){

            $producto_delete->delete();

            $traslado_pendiente_delete->update([
                'cantidad_recibida' => $producto_delete->cantidad,
                'estado' => 'RECIBIDO',
                'observacion_final' => 'Recibido en almacen '. $sucursal->nombre .', por usuario '. $user_auth_nombre .' '. $user_auth_apellido. ' Fecha del registro: '. $fecha_actual
            ]);
        }
        else{
            $producto_delete->update([
                'cantidad' => $producto_delete->cantidad - $this->qty,
            ]);

            $productos_pendientes = $traslado_pendiente_delete->cantidad_enviada - $traslado_pendiente_delete->cantidad_recibida;

            $traslado_pendiente_delete->update([
                'cantidad_recibida' => $traslado_pendiente_delete->cantidad_recibida - $this->qty,
                'estado' => 'PENDIENTE',
                'observacion_final' => 'Se han recibido'.$this->qty.' unidades en almacen '. $sucursal->nombre .', por usuario '. $user_auth_nombre .' '. $user_auth_apellido. ' Fecha del registro: '. $fecha_actual.'pendientes'.$productos_pendientes.'unidades',
            ]);
        }

        $this->reset('qty','isopen');
        
        $this->emitTo('productos.productos-detalle-traslado-recibir','render');
    }
}
