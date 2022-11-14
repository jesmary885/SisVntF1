<?php

namespace App\Http\Livewire\Admin\Marcas;

use App\Models\Marca;
use App\Models\Producto;
use Livewire\Component;
Use Livewire\WithPagination;

class MarcaIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$categoria;

    public function updatingSearch(){
        $this->resetPage();
    }


    public function render()
    {
        $marcas = Marca::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.admin.marcas.marca-index',compact('marcas'));
    }

    public function delete($marcaId){
        $this->marca = $marcaId;
        $busqueda = Producto::where('marca_id',$marcaId)->first();

        if($busqueda) $this->emit('errorSize', 'Esta marca esta asociada a un producto, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar esta marca?','admin.marcas.marca-index','confirmacion','La marca se ha eliminado.');
    }
    public function confirmacion(){
        $marca_destroy = Marca::where('id',$this->marca)->first();
        $marca_destroy->delete();
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de marcas: Haga click en el botón " <i class="fas fa-plus-square"></i> Nueva marca " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de marcas: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada marca y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar marcas: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada marca, si la marca esta asociada a un producto no podrá eliminarla, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
    

}
