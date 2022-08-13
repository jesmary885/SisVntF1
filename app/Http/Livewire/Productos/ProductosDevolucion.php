<?php

namespace App\Http\Livewire\Productos;

use App\Models\Devolucion;
use App\Models\Producto;
use App\Models\Producto_sucursal;
use App\Models\Producto_venta;
use App\Models\ProductoSerialSucursal;
use App\Models\Sucursal;
use App\Models\Venta;
use Livewire\Component;
Use Livewire\WithPagination;

class ProductosDevolucion extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";
    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];
    public $search,$product_select,$devolucion_id,$venta_id,$producto_id, $sucursal_id, $producto_serial_id;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $devoluciones = Devolucion::where('fecha', 'LIKE', '%' . $this->search . '%')
                    ->paginate(5);
        return view('livewire.productos.productos-devolucion',compact('devoluciones'));
    }

    public function inventariar($DevolucionProductoId,$devolucionId,$ventaId){
     //   $this->producto_select = ProductoSerialSucursal::where('id',$DevolucionProductoId)->first();
        $busqueda_sucursal = Venta::where('id',$ventaId)->first();
        $this->sucursal_id = $busqueda_sucursal->sucursal_id;

     
        //$this->venta_id = $ventaId;
        $this->devolucion_id = $devolucionId;
        $this->producto_id = Producto::where('id',$DevolucionProductoId)->first();
      //  dd($this->producto_id);
    
        $this->emit('confirm', 'Esta seguro de enviar el producto a inventario?','productos.productos-devolucion','confirmacion','El producto ha sido registrado en inventario.');
       
    }

    public function confirmacion(){
        $user_auth = auth()->user()->id;  
        $fecha_actual = date('Y-m-d');      

       // dd($this->producto_id);
        $devolucion_eliminar = Devolucion::where('id',$this->devolucion_id)->first();
        

        $producto_sucursal= Producto_sucursal::where('sucursal_id',$this->sucursal_id)
                                            ->where('producto_id',$this->producto_id->id)
                                            ->first();

          //Guardando movimiento de producto para kardex
          $sucursales = Sucursal::all();
          $producto_barra = Producto::where('id',$this->producto_id->id)->first();
  
          $stock_antiguo = $producto_barra->cantidad;
          $stock_nuevo = $stock_antiguo + $devolucion_eliminar->cantidad;
          $producto_barra->movimientos()->create([
              'fecha' => $fecha_actual,
              'cantidad_entrada' => 1,
              'cantidad_salida' => 0,
              'stock_antiguo' => $stock_antiguo,
              'stock_nuevo' => $stock_nuevo,
              'precio_entrada' => 0,
              'precio_salida' => 0,
              'detalle' => 'Integro a deposito de equipo(s) como estado "activo" luego de devolución',
              'user_id' => $user_auth 
          ]);

        $cantidad_nueva_producto = $producto_sucursal->cantidad + $devolucion_eliminar->cantidad;
   
        $producto_sucursal->update([
            'cantidad' => $cantidad_nueva_producto
        ]);

        $devolucion_eliminar->delete();
        $this->resetPage();

    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Registro de devolución: Haga click en el botón "<i class="fas fa-exchange-alt"></i>  Registro de devolución", ubicado en la zona superior derecha.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Regresar equipo a inventario como activo: Haga click en el botón "<i class="fas fa-exchange-alt"></i>", ubicado al lado de la devolución asociada al equipo que desea reintegrar al inventario, el sistema le solicitará confirmación.</p>');
    }
}
