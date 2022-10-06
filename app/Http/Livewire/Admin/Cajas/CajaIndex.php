<?php

namespace App\Http\Livewire\Admin\Cajas;

use App\Models\Caja;
use App\Models\Venta;
use Livewire\Component;
use Livewire\WithPagination;

class CajaIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$caja;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $cajas = Caja::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(15);

        return view('livewire.admin.cajas.caja-index',compact('cajas'));
    }

    public function delete($cajaId){
        $this->caja = $cajaId;
        //$busqueda = Venta::where('caja_id',$cajaId)->first();

       // if($busqueda) $this->emit('errorSize', 'Esta caja esta asociada a una venta, no puede eliminarla');
       /* else*/ $this->emit('confirm', 'Esta seguro de eliminar esta caja?','admin.cajas.caja-index','confirmacion','La caja se ha eliminado.');
    }

    public function confirmacion(){
        $caja_destroy = Caja::where('id',$this->caja)->first();
        $caja_destroy->delete();
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de caja: Haga click en el botón " <i class="fas fa-user-plus"></i> Nuevo cliente " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de cajas: Haga click en el botón " <i class="fas fa-user-edit"></i> ", ubicado al lado de cada cliente y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar cajas: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada cliente, si el cliente esta asociado a una venta no podrá eliminarlo, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
}
