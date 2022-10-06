<?php

namespace App\Http\Livewire\Productos;

use App\Models\Producto;
use App\Models\Producto_lote;
use App\Models\Producto_sucursal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductosLoteCantEdit extends Component
{
    public $lote, $qty, $lote_producto;
    
    public function mount(){

        $this->lote_producto = Producto_sucursal::where('id',$this->lote->id)
            ->first();

        $this->qty = $this->lote_producto->cantidad;
    }
    public function render()
    {
        return view('livewire.productos.productos-lote-cant-edit');
    }

    public function edit_cant(){

        $usuario_auth = Auth::id();
        $this->fecha_actual = date('Y-m-d H:i:s');

        $producto = Producto::where('id',$this->lote_producto->producto_id)
            ->first();
        
        $producto_lote = Producto_lote::where('producto_id',$this->lote_producto->producto_id)
            ->where('lote',$this->lote_producto->lote)
            ->first();

        if ($this->lote_producto->cantidad < $this->qty){
            $new_cant_tab_producto = $producto->cantidad + ($this->qty-$this->lote_producto->cantidad);
            $new_cant_tab_producto_lote = $producto_lote->stock + ($this->qty-$this->lote_producto->cantidad);

            //Agregando nuevo movimiento de incremento en cantidad del producto
            $producto->movimientos()->create([
                'fecha' => $this->fecha_actual,
                'cantidad_entrada' => $this->qty-$this->lote_producto->cantidad,
                'cantidad_salida' => 0,
                'stock_antiguo' => $producto->cantidad,
                'stock_nuevo' => $new_cant_tab_producto,
                'precio_entrada' => ($producto_lote->precio_entrada * ($this->qty-$this->lote_producto->cantidad)),
                'precio_salida' => 0,
                'detalle' => 'Modificación de cantidad (incremento) en Lote de producto',
                'user_id' => $usuario_auth
            ]);
        }
        else{
            $new_cant_tab_producto = $producto->cantidad - ($this->lote_producto->cantidad - $this->qty);
            $new_cant_tab_producto_lote = $producto_lote->stock - ($this->lote_producto->cantidad - $this->qty);
            
            //Agregando nuevo movimiento de decremento en cantidad del producto
            $producto->movimientos()->create([
                'fecha' => $this->fecha_actual,
                'cantidad_entrada' => 0,
                'cantidad_salida' => $this->lote_producto->cantidad - $this->qty,
                'stock_antiguo' => $producto->cantidad,
                'stock_nuevo' => $new_cant_tab_producto,
                'precio_entrada' => 0,
                'precio_salida' => ($producto_lote->precio_entrada * ($this->lote_producto->cantidad - $this->qty)),
                'detalle' => 'Modificación de cantidad (decremento) en Lote de producto',
                'user_id' => $usuario_auth
            ]);
        }

        //Modificación en tabla productos
        $producto->update(["cantidad" => $new_cant_tab_producto]);
        //Modificación en tabla Producto_lote, modificando la cantidad general de ese lote
        $producto_lote->update(["stock" => $new_cant_tab_producto_lote]);
        //Modificando en tabla de producto_sucursal, modificando la cantidad de ese lote en esa sucursal
        $this->lote_producto->update(['cantidad' => $this->qty]);
    }
}
