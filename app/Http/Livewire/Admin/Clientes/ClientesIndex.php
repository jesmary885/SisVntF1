<?php

namespace App\Http\Livewire\Admin\Clientes;

use App\Exports\ClientesExport;
use App\Models\Cliente;
use App\Models\Venta;
use Livewire\Component;
Use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ClientesIndex extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$cliente;

    public function updatingSearch(){
        $this->resetPage();
    }
   
    public function render()
    {

        $clientes = Cliente::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orwhere('nro_documento', 'LIKE', '%' . $this->search . '%')
            ->latest('id')
            ->paginate(5);

        return view('livewire.admin.clientes.clientes-index',compact('clientes'));
    }

    public function delete($clienteId){
        $this->cliente = $clienteId;
        $busqueda = Venta::where('cliente_id',$clienteId)->first();

        if($busqueda) $this->emit('errorSize', 'Este cliente esta asociado a una venta, no puede eliminarlo');
        else $this->emit('confirm', 'Esta seguro de eliminar este cliente?','admin.clientes.clientes-index','confirmacion','El cliente se ha eliminado.');
    }

    public function confirmacion(){
        $cliente_destroy = Cliente::where('id',$this->cliente)->first();
        $cliente_destroy->delete();
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de clientes: Haga click en el botón " <i class="fas fa-user-plus"></i> Nuevo cliente " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de clientes: Haga click en el botón " <i class="fas fa-user-edit"></i> ", ubicado al lado de cada cliente y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar clientes: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada cliente, si el cliente esta asociado a una venta no podrá eliminarlo, de lo contrario confirme haciendo click en la opción " Si, seguro " .</p> ');
    }
    public function export(){
       


        return Excel::download(new ClientesExport(), 'Clientes.xlsx');
    }
}
