<?php

namespace App\Http\Livewire\Admin\Modelos;

use App\Models\Marca;
use App\Models\Modelo;
use Livewire\Component;

class ModeloCreate extends Component
{
    public $nombre,$marcas,$marca_id="";
    public $isopen = false;
    public $accion,$modelo;

    protected $rules = [
        'nombre' => 'required|max:50',
        'marca_id' => 'required',
    ];

    public function mount(Modelo $modelo){

        $this->modelo = $modelo;
        $this->marcas=Marca::all();
        if($modelo){
           $this->nombre = $this->modelo->nombre;
           $this->marca_id = $this->modelo->marca_id;
        }
    }
    
    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function render()
    {
        return view('livewire.admin.modelos.modelo-create');
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        if($this->accion == 'create')
        {
            $modelo = new Modelo();
            $modelo->nombre = $this->nombre;
            $modelo->marca_id = $this->marca_id;
            $modelo->save();

            $this->reset(['nombre','isopen','marca_id']);
            $this->emitTo('admin.modelos.modelo-index','render');

            $this->emit('alert','Categoria creada correctamente');
        }
        else
        {
            $this->modelo->update([
                'nombre' => $this->nombre,
                'marca_id' => $this->marca_id,
            ]);

            $this->reset(['isopen']);
            $this->emitTo('admin.modelos.modelo-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }
}
