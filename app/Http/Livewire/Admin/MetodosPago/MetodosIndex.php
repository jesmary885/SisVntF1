<?php

namespace App\Http\Livewire\Admin\MetodosPago;

use App\Models\Metodo_pago;
use App\Models\Pago_venta;
use Livewire\Component;
use Livewire\WithPagination;

class MetodosIndex extends Component
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
        $metodos = Metodo_pago::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.admin.metodos-pago.metodos-index',compact('metodos'));
    }

    public function delete($metodoId){
        $this->metodo = $metodoId;
        $busqueda = Pago_venta::where('metodo_pago_id',$metodoId)->first();

        if($busqueda) $this->emit('errorSize', 'Esta método esta asociado a una venta, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar este metodo?','admin.metodos-pago.metodos-index','confirmacion','El método se ha eliminado.');
    }

    public function confirmacion(){
        $metodo_destroy = Metodo_pago::where('id',$this->metodo)->first();
        $metodo_destroy->delete();
     $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de métodos: Haga click en el botón " <i class="fas fa-plus-square"></i> Nuevo método " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de métodos: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada método y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar método: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada método, si el método esta asociado a una venta no podrá eliminarlo, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
}
