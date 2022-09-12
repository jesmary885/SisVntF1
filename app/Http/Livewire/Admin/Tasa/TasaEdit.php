<?php

namespace App\Http\Livewire\Admin\Tasa;

use App\Models\tasa_dia;
use Livewire\Component;

class TasaEdit extends Component
{
    public function render()
    {
        return view('livewire.admin.tasa.tasa-edit');
    }

    public $tasa, $tasa_dia;
    public $isopen = false;

    protected $rules = [
        'tasa_dia' => 'required',
    ];

    public function mount(){
       $this->tasa_dia = $this->tasa->tasa;
    }

    public function open()
    {
        $this->isopen = true;  
    }
    
    public function close()
    {
        $this->isopen = false;  
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        $this->tasa->update([
            'tasa' => $this->tasa_dia,
        ]);
        $this->reset(['isopen']);
        $this->emitTo('admin.tasa.tasa-index','render');
        $this->emit('alert','Tasa modificada correctamente');
    }
}
