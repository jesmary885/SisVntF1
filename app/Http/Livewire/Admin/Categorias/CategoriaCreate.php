<?php

namespace App\Http\Livewire\Admin\Categorias;

use App\Models\Categoria;
use Livewire\Component;

class CategoriaCreate extends Component
{
    public $nombre;
    public $isopen = false;
    public $accion,$categoria;

    protected $rules = [
        'nombre' => 'required|max:50|unique:categorias',
    ];

    public function mount(Categoria $categoria){
        $this->categoria = $categoria;
        if($categoria){
           $this->nombre = $this->categoria->nombre;
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
        return view('livewire.admin.categorias.categoria-create');
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        if($this->accion == 'create')
        {
            $categoria = new Categoria();
            $categoria->nombre = $this->nombre;
            $categoria->save();

            $this->reset(['nombre','isopen']);
            $this->emitTo('admin.categorias.categoria-index','render');

            $this->emit('alert','Categoria creada correctamente');
        }
        else
        {
            $this->categoria->update([
                'nombre' => $this->nombre,
            ]);
            $this->reset(['isopen']);
            $this->emitTo('admin.categorias.categoria-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }
}
