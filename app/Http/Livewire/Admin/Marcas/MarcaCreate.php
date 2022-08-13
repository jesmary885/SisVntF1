<?php

namespace App\Http\Livewire\Admin\Marcas;

use App\Models\Marca;
use Livewire\Component;

class MarcaCreate extends Component
{
    public $nombre;
    public $isopen = false;
    public $accion,$marca;

    protected $rules = [
        'nombre' => 'required|max:50',
    ];

    public function mount(Marca $marca){
        $this->marca = $marca;
        if($marca){
           $this->nombre = $this->marca->nombre;
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
        return view('livewire.admin.marcas.marca-create');
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        if($this->accion == 'create')
        {
            $marca = new Marca();
            $marca->nombre = $this->nombre;
            $marca->save();

            $this->reset(['nombre','isopen']);
            $this->emitTo('admin.marcas.marca-index','render');

            $this->emit('alert','Marca creada correctamente');
        }
        else
        {
            $this->marca->update([
                'nombre' => $this->nombre,
            ]);
            $this->reset(['isopen']);
            $this->emitTo('admin.marcas.marca-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }

}
