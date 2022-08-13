<?php

namespace App\Http\Livewire\Admin\Compras;

use App\Models\Compra;
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
    public $limitacion_sucursal = true;
      
    protected $rules = [
        'cantidad' => 'required',
        'sucursal_id' => 'required',
        'precio_compra' => 'required',
        'proveedor_id' => 'required',
    ];

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function mount(Compra $compra){
        
         $usuario_au = User::where('id',Auth::id())->first();
         if($usuario_au->limitacion == '1'){
             $this->sucursales=Sucursal::all();
         }else{
             $this->limitacion_sucursal = false;
             $this->sucursal_id = $usuario_au->sucursal_id;
             $sucursal_usuario = Sucursal::where('id',$this->sucursal_id)->first();
             $this->sucursal_nombre = $sucursal_usuario->nombre;
         }
         $this->proveedor_id = $compra->proveedor_id;
         $this->cantidad = $compra->cantidad;
         $this->precio_compra = $compra->precio_compra;
         $this->sucursal_id = $compra->sucursal_id;

         $this->proveedores=Proveedor::all();
     }

    public function render()
    {
        return view('livewire.admin.compras.compras-edit');
    }

   public function save(){

        $rules = $this->rules;
        $this->validate($rules);

        $usuario_auth = Auth::id();
        $this->fecha_actual = date('Y-m-d');
        $total_compra = ($this->precio_compra * $this->cantidad);
        $producto = Producto::where('id',$this->compra->producto_id)->first();

        if($this->cantidad < $this->compra->cantidad) {
            $cant_diferencia = $this->compra->cantidad - $this->cantidad;
            $cantidad_nueva_sucursal = $producto->sucursals->find($this->sucursal_id)->pivot->cantidad - $cant_diferencia;
        } elseif ($this->cantidad > $this->compra->cantidad){
            $cant_diferencia = $this->cantidad - $this->compra->cantidad;
            $cantidad_nueva_sucursal = $producto->sucursals->find($this->sucursal_id)->pivot->cantidad + $cant_diferencia;

        }elseif($this->cantidad == $this->compra->cantidad){
            $cantidad_nueva_sucursal = $this->cantidad;
        }

        if($this->sucursal_id == $this->compra->sucursal_id){
            $pivot = Pivot::where('sucursal_id',$this->sucursal_id)
            ->where('producto_id',$producto->id)
            ->first();
            $pivot->cantidad = $cantidad_nueva_sucursal;
            $pivot->save();
        } else{
            $pivot = Pivot::where('sucursal_id',$this->sucursal_id)
            ->where('producto_id',$producto->id)
            ->first();
            $pivot->cantidad = $cantidad_nueva_sucursal;
            $pivot->save();

            $pivot2 = Pivot::where('sucursal_id',$this->compra->sucursal_id)
            ->where('producto_id',$producto->id)
            ->first();
            $cant_diferencia_sucursal = $pivot2->cantidad - $this->compra->cantidad;
            $pivot2->cantidad = $cant_diferencia_sucursal;
            $pivot2->save();
        }

        $this->compra->update([
            'total' => $total_compra,
            'precio_compra' => $this->precio_compra,
            'cantidad' => $this->cantidad,
            'proveedor_id' => $this->proveedor_id,
            'sucursal_id' => $this->sucursal_id,
            'user_id' => $usuario_auth
        ]);

         //registrando moviemientos en tabla movimientos
    

        $this->reset(['isopen']);
        $this->emitTo('admin.compras.compra-index','render');
        $this->emit('alert','Datos modificados correctamente');
    }
}
