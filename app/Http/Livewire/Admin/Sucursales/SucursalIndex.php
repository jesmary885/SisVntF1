<?php

namespace App\Http\Livewire\Admin\Sucursales;

use App\Models\Producto_sucursal;
use App\Models\Sucursal;
use Livewire\Component;
Use Livewire\WithPagination;

class SucursalIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$sucursal;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        $sucursales = Sucursal::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(5);

        return view('livewire.admin.sucursales.sucursal-index',compact('sucursales'));
    }

    
    public function delete($sucursalId){
        $this->sucursal = $sucursalId;
        $busqueda = Producto_sucursal::where('sucursal_id',$sucursalId)->get();
        $cant = 0;
        foreach($busqueda as $i){
            if($i->cantidad > 0){
                $cant++;
                break;
            } 
        }

        if($cant > 0) $this->emit('errorSize', 'Esta sucursal esta asociada a un producto, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar esta susucrsal?','admin.sucursales.sucursal-index','confirmacion','La sucursal se ha eliminado.');
    }
    public function confirmacion(){
        $sucursal_destroy = Sucursal::where('id',$this->sucursal)->first();
        $sucursal_destroy->update([
            'status' => 0,
        ]);
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de sucursales: Haga click en el botón " <i class="fas fa-warehouse"></i> Nueva sucursal  " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de sucursales: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada sucursal y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar sucursal: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada sucursal, si la sucursal esta asociada a un producto no podrá eliminarla, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
}
