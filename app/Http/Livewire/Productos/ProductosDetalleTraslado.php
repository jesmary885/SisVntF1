<?php

namespace App\Http\Livewire\Productos;

use App\Models\Movimiento;
use App\Models\Movimiento_product_serial;
use App\Models\Producto;
use App\Models\Producto_lote;
use App\Models\Sucursal;
use Livewire\Component;
use App\Models\Producto_sucursal as Pivot;
use App\Models\ProductoSerialSucursal;
use App\Models\ProductosTraslado;
use App\Models\Traslado;
use PDF;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class ProductosDetalleTraslado extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $isopen = false;
    public $sucursal,$produ_s_r, $cant_total, $cantidad, $sucursal_id = "", $sucursales, $prod, $prodr, $buscador=0, $product_cod_barra,$cant_cod_barra = [],$producto_s =[],$cant_registros = 0,$array_productos;

    protected $listeners = ['render' => 'render', 'actualizar' => 'actualizar'];

    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->sucursales = Sucursal::where('id', '!=', $this->sucursal)->get();
    }
    public function render()
    {
        if($this->search){
            if($this->buscador == '0'){
               /* $productos = Producto::where('cod_barra', 'LIKE', '%' . $this->search . '%')
                ->latest('id')
                ->paginate();
*/
                /*$lotes = Producto_lote::whereHas('producto',function(Builder $query){
                    $query->where('cod_barra', 'LIKE', '%' . $this->search . '%')
                    ->where('estado','Habilitado');
                })
                    ->where('status','activo')
                   ->latest('id')
                    ->paginate(5);*/
                $productos = Pivot::whereHas('producto',function(Builder $query){
                    $query->where('cod_barra', 'LIKE', '%' . $this->search . '%')
                    ->where('estado','Habilitado');
                })
                    ->where('sucursal_id',$this->sucursal)
                   ->latest('id')
                    ->paginate(5);

            }
        
         /*   elseif($this->buscador == '1'){
                    $productos = Producto::where('estado', 1)
                    ->whereHas('marca',function(Builder $query){
                        $query->where('nombre', 'LIKE', '%' . $this->search . '%');
                    })->latest('id')
                    ->paginate(10);


            }
        
            elseif($this->buscador == '2'){
                    $productos = Producto::where('estado', 1)
                    ->whereHas('categoria',function(Builder $query){
                        $query->where('nombre', 'LIKE', '%' . $this->search . '%');
                    })->latest('id')
                    ->paginate(10);
            }
            else{
                $this->item_buscar = "el código de barra del producto a buscar";
                $productos = Producto::where('estado', 1)
                ->whereHas('modelo',function(Builder $query){
                    $query->where('nombre', 'LIKE', '%' . $this->search . '%');
                })->latest('id')
                ->first();
            }*/
        }
        else{
            $productos = [];
        }

     
        

    

        return view('livewire.productos.productos-detalle-traslado', compact('productos'));
    }






    public function ayuda()
    {
        $this->emit('ayuda', '<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Seleccionar sucursal destino: Seleccione la sucursal destino en el select ubicado en la zona superior izquierda</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Seleccionar equipos por serial a trasladar: Haga click en el check cuadrado ubicado al lado de cada equipo.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-. Procesar traslado: Una vez haya seleccionado todos los equipos a trasladar haga click en el botón Procesar</p>');
    }
}
