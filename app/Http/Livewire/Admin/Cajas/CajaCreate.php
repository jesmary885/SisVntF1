<?php

namespace App\Http\Livewire\Admin\Cajas;

use App\Models\Caja;
use App\Models\Sucursal;
use Livewire\Component;

class CajaCreate extends Component
{
    public $nombre,$status,$saldo,$sucursal_id="";
    public $isopen = false;
    public $accion,$sucursales;

    protected $rules = [
        'nombre' => 'required|max:50',
        'sucursal_id' => 'required',
        'status' => 'required',
        'saldo' => 'required',
    ];

    public function mount(Caja $caja){

        $this->caja = $caja;
        $this->sucursales=Sucursal::all();
        if($caja){
           $this->nombre = $this->caja->nombre;
           $this->sucursal_id = $this->caja->sucursal_id;
           $this->status= $this->caja->status;
           $this->saldo= $this->caja->saldo;
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
        return view('livewire.admin.cajas.caja-create');
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        if($this->accion == 'create')
        {
            $caja = new Caja();
            $caja->nombre = $this->nombre;
            $caja->sucursal_id = $this->sucursal_id;
            $caja->status = $this->status;
            $caja->saldo = $this->saldo;
            $caja->save();

            $this->reset(['nombre','isopen','sucursal_id','status','saldo']);
            $this->emitTo('admin.cajas.caja-index','render');

            $this->emit('alert','Caja creada correctamente');
        }
        else
        {
            $this->caja->update([
                'nombre' => $this->nombre,
                'sucursal_id' => $this->sucursal_id,
                'status_id' => $this->status_id,
                'saldo' => $this->saldo,
            ]);

            $this->reset(['isopen']);
            $this->emitTo('admin.cajas.caja-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }
}
