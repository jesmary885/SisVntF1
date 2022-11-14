<?php

namespace App\Http\Livewire\Admin\Modelos;

use App\Models\Modelo;
use App\Models\Producto;
use Livewire\Component;
Use Livewire\WithPagination;

class ModeloIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$modelo;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $modelos = Modelo::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.admin.modelos.modelo-index',compact('modelos'));
    }
    public function delete($modeloId){
        $this->modelo = $modeloId;
        $busqueda = Producto::where('modelo_id',$modeloId)->first();

        if($busqueda) $this->emit('errorSize', 'Este modelo esta asociado a un producto, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar este modelo?','admin.modelos.modelo-index','confirmacion','El modelo se ha eliminado.');
    }
    public function confirmacion(){
        $modelo_destroy = Modelo::where('id',$this->modelo)->first();
        $modelo_destroy->delete();
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de modelos: Haga click en el botón " <i class="fas fa-plus-square"></i> Nuevo modelo " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de modelos: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada modelo y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar modelos: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada modelo, si el modelo esta asociado a un producto no podrá eliminarlo, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
}
