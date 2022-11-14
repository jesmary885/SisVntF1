<?php

namespace App\Http\Livewire\Admin\Categorias;

use App\Models\Categoria;
use App\Models\Producto;
use Livewire\Component;
Use Livewire\WithPagination;

class CategoriaIndex extends Component
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
        $categorias = Categoria::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.admin.categorias.categoria-index',compact('categorias'));
    }

    public function delete($categoriaId){
        $this->categoria = $categoriaId;
        $busqueda = Producto::where('categoria_id',$categoriaId)->first();

        if($busqueda) $this->emit('errorSize', 'Esta categoria esta asociada a un producto, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar esta categoria?','admin.categorias.categoria-index','confirmacion','La categoria se ha eliminado.');
    }

    public function confirmacion(){
        $categoria_destroy = Categoria::where('id',$this->categoria)->first();
        $categoria_destroy->delete();
     $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de categorias: Haga click en el botón " <i class="fas fa-plus-square"></i> Nueva categoria " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de categorias: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada categoría y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar categorias: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada categoría, si la categoría esta asociada a un producto no podrá eliminarla, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
}
