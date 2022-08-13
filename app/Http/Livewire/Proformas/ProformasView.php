<?php

namespace App\Http\Livewire\Proformas;

use App\Models\Proforma;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ProformasView extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";


    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$buscador,$item_buscar;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        if($this->buscador == 0){
            $proformas = Proforma::where('fecha', 'LIKE', '%' . $this->search . '%')
            ->latest('id')
            ->paginate(5);

            $this->item_buscar = "la fecha de la proforma a buscar";
        }

        elseif ($this->buscador == 1){
            $proformas = Proforma::whereHas('cliente',function(Builder $query){
                $query->where('nombre','LIKE', '%' . $this->search . '%')
                ->orwhere('apellido','LIKE', '%' . $this->search . '%')
                ->orwhere('nro_documento','LIKE', '%' . $this->search . '%');
             })->paginate(5);

             $this->item_buscar = "el nombre, apellido o nro de documento del cliente asociado a la proforma a buscar";
        }

        else{
            $proformas = Proforma::whereHas('user',function(Builder $query){
                $query->where('name','LIKE', '%' . $this->search . '%')
                ->orwhere('apellido','LIKE', '%' . $this->search . '%');
             })->paginate(5);

             $this->item_buscar = "el nombre o apellido del usuario asociado a la proforma a buscar";

        }

        


        return view('livewire.proformas.proformas-view',compact('proformas'));
    }
}
