<?php

namespace App\Http\Livewire\Productos;

use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;
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
        $producto_id = $producto->id;

        $productos_sucursal_encode = DB::select('SELECT ps.cantidad, ps.lote, s.nombre from producto_sucursal ps 
            inner join sucursals s on s.id=ps.sucursal_id
            where ps.producto_id = :producto_id AND ps.status = "activo"',array('producto_id' => $producto_id));

        $productos_sucursal_decode = json_encode($productos_sucursal_encode);
        $productos_sucursal =json_decode($productos_sucursal_decode);

        return view('livewire.productos.productos-stock-sucursal',compact('productos_sucursal','producto'));
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
