<?php

namespace App\Http\Livewire\Productos;

use App\Models\Moneda;
use App\Models\Producto;
use App\Models\Producto_lote;
use App\Models\tasa_dia;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProductosLote extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];


    public $search, $producto,$item_buscar,$tasa_dia,$moneda_nombre,$moneda_simbolo;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        if($this->search){
            $lotes = Producto_lote::whereHas('producto',function(Builder $query){
                $query->where('cod_barra', 'LIKE', '%' . $this->search . '%')
                ->where('estado','Habilitado');
            })
                ->where('status','activo')
                ->latest('id')
                ->paginate(5);
        }
        else{
            $lotes = 0;
        }

        if(session()->has('moneda')){
            $this->moneda = Moneda::where('nombre',session('moneda'))->first();
            $this->moneda_nombre = session('moneda');
            $this->moneda_simbolo = session('simbolo_moneda');
            if(session('moneda') == "Bolivar") $this->tasa_dia = 1;
            else $this->tasa_dia = tasa_dia::where('moneda_id',$this->moneda->id)->first()->tasa;
        } 
        else{
            $this->moneda = Moneda::where('nombre','Bolivar')->first();
            $this->moneda_nombre = 'Bolivar';
            $this->moneda_simbolo = 'Bs';
            $this->tasa_dia = 1;
        } 


        
        return view('livewire.productos.productos-lote',compact('lotes'));
    }
    public function delete($loteId){
       
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
