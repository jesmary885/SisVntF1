<?php

namespace App\Http\Livewire\Productos;

use App\Models\Producto;
use App\Models\Producto_sucursal;
use App\Models\Producto_venta;
use App\Models\ProductoSerialSucursal;
use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
Use Livewire\WithPagination;

class ProductosIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];


    public $search, $producto,$buscador;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {

        $sucursales = Sucursal::all();

        if($this->buscador == 0){

            $productos = Producto::whereHas('modelo',function(Builder $query){
                $query->where('nombre','LIKE', '%' . $this->search . '%');
            })->where('estado','Habilitado')
            ->latest('id')
            ->paginate(5);

            $this->item_buscar = "el modelo del producto a buscar";
        }
        elseif($this->buscador == 1){

            $productos = Producto::whereHas('categoria',function(Builder $query){
                $query->where('nombre','LIKE', '%' . $this->search . '%')
                ->where('estado','Habilitado');
            })
            ->latest('id')
            ->paginate(5);

            $this->item_buscar = "la categoria del producto a buscar";
        }
        elseif($this->buscador == 2){

            $productos = Producto::whereHas('marca',function(Builder $query){
                $query->where('nombre','LIKE', '%' . $this->search . '%')
                ->where('estado','Habilitado');
            })
            ->latest('id')
            ->paginate(5);

            $this->item_buscar = "la marca del producto a buscar";
        }

        else{
            $productos = Producto::where('cod_barra', 'LIKE', '%' . $this->search . '%')
            ->orwhere('nombre', 'LIKE', '%' . $this->search . '%')
            ->where('estado','Habilitado')
            ->latest('id')
            ->paginate(5);
            
            $this->item_buscar = "el código de barra o nombre del producto a buscar";
        }

        return view('livewire.productos.productos-index',compact('productos','sucursales'));
    }

    public function delete($productoId){
        $this->producto = $productoId;
        $busqueda = Producto_venta::where('producto_id',$productoId)->first();
        if($busqueda) $this->emit('errorSize', 'Este producto esta asociado a una venta, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar este producto?','productos.productos-index','confirmacion','El producto se ha eliminado.');
    }

    public function confirmacion(){
        $this->fecha_actual = date('Y-m-d');
        $usuario_auth = Auth::id();
        $user_auth_nombre =  auth()->user();
        $sucursales = Sucursal::all();

        $producto_destroy = Producto::where('id',$this->producto)->first();

        //inactivando producto en tabla productos
        
        $producto_destroy->update([
            'estado' => 'inactivo por eliminación, por usuario'. $user_auth_nombre->nombre. ' ' . $user_auth_nombre->apellido. 'en fecha:' .$this->fecha_actual,
        ]);

       
        //registrando movimiento de producto eliminado en kardex
        $stock_antiguo = 0;
        foreach($sucursales as $sucursalx){

            $stock_antiguo = $producto_destroy->sucursals->find($sucursalx)->pivot->cantidad + $stock_antiguo;
        }


        $producto_destroy->movimientos()->create([
            'fecha' => $this->fecha_actual,
            'cantidad_entrada' => 0,
            'stock_antiguo' => $stock_antiguo,
            'stock_nuevo' => 0,
            'cantidad_salida' => $stock_antiguo,
            'precio_entrada' => 0,
            'precio_salida' => 0,
            'detalle' => 'Eliminación de producto, por usuario'. $user_auth_nombre->nombre. ' ' . $user_auth_nombre->apellido. 'en fecha:' .$this->fecha_actual,
            'user_id' => $usuario_auth
        ]);

        //disminuyendo la cantidades de productos en la tabla pivote producto_sucursal

        $producto_cod_barra_cant = Producto_sucursal::where('producto_id',$producto_destroy->id)->get();
        foreach($producto_cod_barra_cant as $producto_cod_bc){
            $producto_cod_bc->update([
                'cantidad' => 0,
            ]);
        }

        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Registro de equipos: Haga click en el botón "<i class="fas fa-plus-square"></i> Nuevo equipo", ubicado en la zona superior derecha y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Exportar inventario: Haga click en el botón "<i class="far fa-file-excel"></i> Exportar inventario" ubicado en la zona superior derecha, complete el formulario y haga click en Exportar.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Agregar unidades a un tipo de equipo: Haga click en el botón "<i class="fas fa-plus-square"></i>" ubicado eal lado de cada equipo registrado y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">4-.Editar información de equipos: Haga click en el botón "<i class="far fa-edit"></i>" ubicado al lado de cada equipo, complete el formulario y haga click en Guardar.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">5-.Ver stock de equipos por almacen: Haga click en el botón "<i class="fas fa-warehouse"></i>" ubicado al lado del stock de cada equipo y le aparecerá la información detallada por sucursal.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">6-.Imrpimir códigos de barra: Haga click en el botón "<i class="far fa-file-excel"></i> Exportar inventario" ubicado en la zona superior derecha, complete el formulario y haga click en Exportar.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">7-.Eliminar equipo: Haga click en el botón "<i class="fas fa-trash-alt"></i>", si el equipo esta asociado a alguna venta no podrá eliminarlo, de lo contrario el sistema solicitará confirmación.</p>');
    }

   
}
