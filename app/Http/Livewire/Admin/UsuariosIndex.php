<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Queue\Listener;
Use Livewire\WithPagination;

use Livewire\Component;

class UsuariosIndex extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render'];

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {

        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
                    ->orwhere('email', 'LIKE', '%' . $this->search . '%')
                    ->paginate();
        return view('livewire.admin.usuarios-index',compact('users'));
    }
    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de usuarios: Haga click en el botón " <i class="fas fa-user-plus"></i> Nuevo usuario " y complete el formulario.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar datos de usuarios: Haga click en el botón " <i class="fas fa-user-edit"></i> ", ubicado al lado de cada usuario y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Desactivar usuarios: Haga click en el botón " <i class="fas fa-user-edit"></i> ", ubicado al lado de cada usuario y en el apartado de Información de la cuenta haga click en Activa y seleccione la opción Inactiva, luego haga click en Guardar');
    }
}
