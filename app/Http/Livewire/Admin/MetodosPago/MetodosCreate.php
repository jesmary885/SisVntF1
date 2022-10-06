<?php

namespace App\Http\Livewire\Admin\MetodosPago;

use App\Models\Metodo_pago;
use Livewire\Component;

class MetodosCreate extends Component
{
    public $nombre;
    public $isopen = false;
    public $accion,$metodo;

    protected $rules = [
        'nombre' => 'required|max:50',
    ];

    public function mount(Metodo_pago $metodo){
        $this->metodo = $metodo;
        if($metodo){
           $this->nombre = $this->metodo->nombre;
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
        return view('livewire.admin.metodos-pago.metodos-create');
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        if($this->accion == 'create')
        {
            $metodo = new Metodo_pago();
            $metodo->nombre = $this->nombre;
            $metodo->save();

            $this->reset(['nombre','isopen']);
            $this->emitTo('admin.metodos-pago.metodos-index','render');

            $this->emit('alert','Método de pago creado correctamente');
        }
        else
        {
            $this->metodo->update([
                'nombre' => $this->nombre,
            ]);
            $this->reset(['isopen']);
            $this->emitTo('admin.metodos-pago.metodos-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }
}
