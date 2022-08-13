<?php

namespace App\Http\Livewire\Productos;

use App\Models\Producto_cod_barra_serial;
use App\Models\ProductoSerialSucursal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductosAddSerial extends Component
{

    public $isopen = false;
    public $serial, $producto;
      
    protected $rules = [
        'serial' => 'required|unique:producto_serial_sucursals',
    ];

     public function mount(){
        $this->serial = $this->producto->serial;
      }
    public function render()
    {
        return view('livewire.productos.productos-add-serial');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function save()
    {
        $rules = $this->rules;
        $this->validate($rules);

        $this->fecha_actual = date('Y-m-d');
        $usuario_auth = Auth::id();
   
         $this->producto->update([
             'serial' => $this->serial
         ]);

        /* $this->producto->movimientos()->create([
            'fecha' => $this->fecha_actual,
            'tipo_movimiento' => 'Registro de serial',
            'precio' => $this->producto->producto->precio_letal,
            'observacion' => 'Registro de unidad',
            'user_id' => $usuario_auth
        ]);*/

        $this->reset(['isopen']);
        $this->emitTo('productos.productos-serial-index','render');
       // $this->emit('alert','Datos registrados correctamente');
    }

   
}
