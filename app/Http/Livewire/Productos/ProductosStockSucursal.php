<?php

namespace App\Http\Livewire\Productos;

use App\Models\Sucursal;
use Livewire\Component;

class ProductosStockSucursal extends Component
{

    public $producto;
    public $isopen = false;

    protected $listeners = ['render' => 'render'];

    public function render()
    {

        $sucursales = Sucursal::all();
        $producto = $this->producto;

        return view('livewire.productos.productos-stock-sucursal',compact('sucursales','producto'));
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

}
