<?php

namespace App\Http\Livewire\Admin\Proveedores;

use App\Models\Compra;
use App\Models\Proveedor;
use Livewire\Component;
Use Livewire\WithPagination;

class ProveedorIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$proveedor;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {
        $proveedores = Proveedor::where('nombre_proveedor', 'LIKE', '%' . $this->search . '%')
        ->orwhere('nro_documento', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.admin.proveedores.proveedor-index',compact('proveedores'));
    }

    public function delete($proveedorId){
        $this->proveedor = $proveedorId;
        $busqueda = Compra::where('proveedor_id',$proveedorId)->first();

        if($busqueda) $this->emit('errorSize', 'Este proveedor esta asociado a una compra, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar este proveedor?','admin.proveedores.proveedor-index','confirmacion','El proveedor se ha eliminado.');
    }
    public function confirmacion(){
        $proveedor_destroy = Proveedor::where('id',$this->proveedor)->first();
        $proveedor_destroy->delete();
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de proveedores: Haga click en el botón " <i class="fas fa-user-plus"></i> Nuevo proveedor " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de proveedores: Haga click en el botón " <i class="fas fa-user-edit"></i> ", ubicado al lado de cada proveedor y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar proveedor: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada proveedor, si el proveedor esta asociado a una compra de producto no podrá eliminarlo, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
}
