<?php

namespace App\Http\Livewire\Admin\Sucursales;

use App\Models\Ciudad;
use App\Models\Estado;
use App\Models\Sucursal;
use Livewire\Component;

class SucursalCreate extends Component
{

    public $estado_id ="",$ciudad_id ="";
    public $nombre, $telefono, $ciudades, $direccion, $estados, $status;
    public $isopen = false;
    public $accion, $sucursal;

    protected $rules = [
        'estado_id' => 'required',
        'ciudad_id' => 'required',
        'nombre' => 'required|max:50',
        'direccion' => 'required|max:50',
        'telefono' => 'required|min:5',
        'status' => 'required'
    ];

   /* public function updatedCiudadId($value)
    {
        $ciudad_select = Ciudad::find($value);
        $this->estados = $ciudad_select->estados;
    }*/

    public function updatedEstadoId($value)
    {
        $estado_select = Estado::find($value);
        $this->ciudades = $estado_select->ciudades;
    }

    public function mount(Sucursal $sucursal){
        $this->sucursal = $sucursal ;
        if($this->accion=='create'){
            $this->ciudades=[];
        }else{
            $this->ciudades=Ciudad::all();
        }

        if($sucursal){
            $this->telefono = $this->sucursal->telefono;
            $this->nombre = $this->sucursal->nombre;
            $this->direccion = $this->sucursal->direccion;
            $this->ciudad_id = $this->sucursal->ciudad_id;
            $this->estado_id = $this->sucursal->estado_id;
            $this->status = $this->sucursal->status;
        }
       
        $this->estados=Estado::all();
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
        return view('livewire.admin.sucursales.sucursal-create');
    }

    public function save(){
        $rules = $this->rules;
        $this->validate($rules);

        if($this->accion == 'create')
        {
            $sucursal = new Sucursal();
            $sucursal->nombre = $this->nombre;
            $sucursal->direccion= $this->direccion;
            $sucursal->telefono = $this->telefono;
            $sucursal->ciudad_id = $this->ciudad_id;
            $sucursal->estado_id = $this->estado_id;
            $sucursal->status = $this->status;
            $sucursal->save();

            $this->reset(['nombre','telefono','direccion','ciudad_id','estado_id','isopen','status']);
            $this->emitTo('admin.sucursales.sucursal-index','render');

            $this->emit('alert','Sucursal creada correctamente');
        }
        else
        {
            $this->sucursal->update([
                'nombre' => $this->nombre,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'ciudad_id' => $this->ciudad_id,
                'estado_id' => $this->estado_id,
                'status' => $this->status,
            ]);
            $this->reset(['isopen']);
            $this->emitTo('admin.sucursales.sucursal-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }
}
