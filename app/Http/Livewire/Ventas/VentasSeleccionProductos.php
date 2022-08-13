<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Producto_sucursal;
use App\Models\ProductoSerialSucursal;
use App\Models\Sucursal;
use Livewire\Component;
Use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;


class VentasSeleccionProductos extends Component
{

    use WithPagination;
    public $search, $sucursal,$pivot,$buscador=0,$modalidad_busqueda,$tipo,$proforma;
    protected $listeners = ['render']; 
    protected $paginationTheme = "bootstrap";


    public function mount(){
        //$this->buscador = "1";
    }

    public function render()
    {
        $sucursal = $this->sucursal;
        $usuario =  auth()->user()->id;
        $sucursales = Sucursal::all();
        $proforma = $this->proforma;

       if($this->buscador == '0'){


        $productos = Producto::where('estado', 1)
        ->whereHas('modelo',function(Builder $query){
            $query->where('nombre', 'LIKE', '%' . $this->search . '%');
         })->latest('id')
         ->paginate(10);

         $this->item_buscar = "el modelo del producto a buscar";
        }

        elseif($this->buscador == '1'){


            $productos = Producto::where('estado', 1)
            ->whereHas('marca',function(Builder $query){
                $query->where('nombre', 'LIKE', '%' . $this->search . '%');
             })->latest('id')
             ->paginate(10);
    
             $this->item_buscar = "la marca del producto a buscar";
        }

        elseif($this->buscador == '2'){


            $productos = Producto::where('estado', 1)
            ->whereHas('categoria',function(Builder $query){
                $query->where('nombre', 'LIKE', '%' . $this->search . '%');
             })->latest('id')
             ->paginate(10);
    
             $this->item_buscar = "la categoria del producto a buscar";
        }

        elseif($this->buscador == '3'){
            $productos = Producto::where('estado', 1)
            ->where('cod_barra', 'LIKE', '%' . $this->search . '%')
            ->latest('id')
             ->paginate(10);
    
             $this->item_buscar = "el código de barra del producto a buscar";
        }


        return view('livewire.ventas.ventas-seleccion-productos',compact('productos','sucursal','sucursales','proforma','usuario'));
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Agregar equipos a la venta: Haga click en el botón " <i class="fas fa-check"></i> ", ubicado al lado de cada producto y en el formulario seleccione el tipo de precio que utilizara en la venta (Precio letal o al mayor) y haga click en el boton "Agregar a la venta".</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Si selecciona el mismo producto dos veces el sistema le informará que ya el producto esta registrado en la venta e ignorará su petición</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Si ya ha seleccionado todos los productos haga click en el boton " Continuar>>".</p>');
    }
}
