<?php

namespace App\Http\Livewire\Admin\Proveedores;

use App\Models\Ciudad;
use App\Models\Estado;
use App\Models\Proveedor;
use Livewire\Component;

class ProveedorCreate extends Component
{

    public $estado_id ="",$ciudad_id ="";
    public $nombre_encargado, $nombre_proveedor, $tipo_documento, $nro_documento, $telefono, $email, $ciudades, $direccion, $proveedo, $estados;
    public $isopen = false;
    public $vista, $accion, $proveedor;

    protected $rules = [
        'estado_id' => 'required',
        'ciudad_id' => 'required',
        'nombre_encargado' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'nombre_proveedor' => 'required|max:30',
        'direccion' => 'required|max:50',
        'nro_documento' => 'required|numeric|min:5|unique:proveedors',
        'tipo_documento' => 'required',
        'telefono' => 'required|numeric|min:11',
        'email' => 'required|max:50|unique:proveedors'
    ];

    protected $rules_edit = [
        'estado_id' => 'required',
        'ciudad_id' => 'required',
        'nombre_encargado' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'nombre_proveedor' => 'required|max:30',
        'direccion' => 'required|max:50',
        'tipo_documento' => 'required',
        'telefono' => 'required|numeric|min:9',
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

    public function mount(Proveedor $proveedor){
        if($this->accion=='create'){
            $this->ciudades=[];
        }else{
            $this->ciudades=Ciudad::all();
        }

        $this->proveedor = $proveedor;
        if($proveedor){
            $this->tipo_documento = $this->proveedor->tipo_documento;
            $this->nro_documento = $this->proveedor->nro_documento;
            $this->telefono = $this->proveedor->telefono;
            $this->nombre_encargado = $this->proveedor->nombre_encargado;
            $this->nombre_proveedor = $this->proveedor->nombre_proveedor;
            $this->email = $this->proveedor->email;
            $this->direccion = $this->proveedor->direccion;
            $this->ciudad_id = $this->proveedor->ciudad_id;
            $this->estado_id = $this->proveedor->estado_id;
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
        return view('livewire.admin.proveedores.proveedor-create');
    }

    public function save(){
       

        if($this->accion == 'create')
        {
            $rules = $this->rules;
            $this->validate($rules);

            $proveedor = new Proveedor();
            $proveedor->nombre_encargado = $this->nombre_encargado;
            $proveedor->nombre_proveedor = $this->nombre_proveedor;
            $proveedor->email = $this->email;
            $proveedor->nro_documento = $this->nro_documento;
            $proveedor->tipo_documento = $this->tipo_documento;
            $proveedor->direccion= $this->direccion;
            $proveedor->telefono = $this->telefono;
            $proveedor->ciudad_id = $this->ciudad_id;
            $proveedor->estado_id = $this->estado_id;
            $proveedor->save();

            $this->reset(['nombre_encargado','nombre_proveedor','email','telefono','nro_documento','tipo_documento','direccion','ciudad_id','estado_id','isopen']);
            $this->emitTo('admin.proveedores.proveedor-index','render');

            $this->emit('alert','Proveedor creado correctamente');
        }
        else
        {
            $rules_edit = $this->rules_edit;
            $this->validate($rules_edit);

            $rule_email = [
                'email' => 'required|max:50|email|unique:proveedors,email,' .$this->proveedor->id,
            ];

            $rule_documento = [
                'nro_documento' => 'required|min:5|unique:proveedors,nro_documento,' .$this->proveedor->id,
            ];

            $this->validate($rule_email);
            $this->validate($rule_documento);

            $this->proveedor->update([
                'nombre_encargado' => $this->nombre_encargado,
                'nombre_proveedor' => $this->nombre_proveedor,
                'email' => $this->email,
                'nro_documento' => $this->nro_documento,
                'tipo_documento' => $this->tipo_documento,
                'direccion' => $this->direccion,
                'telefono' => $this->telefono,
                'ciudad_id' => $this->ciudad_id,
                'estado_id' => $this->estado_id,
            ]);
            $this->reset(['isopen']);
            $this->emitTo('admin.proveedores.proveedor-index','render');
            $this->emit('alert','Datos modificados correctamente');
        }
    }
}
