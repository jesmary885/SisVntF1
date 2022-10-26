<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ciudad;
use App\Models\Estado;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;

class UsuariosCreate extends Component
{
    use WithPagination;

    public $estado_id ="",$ciudad_id ="", $roles_id, $sucursales_id = "";
    public $ciudades = [];
    public $name, $apellido, $changePrice, $sucursales, $limitacion, $roles, $tipo_documento, $nro_documento, $telefono, $email, $estado, $password, $direccion, $password_confirm, $estados;
    
    protected $rules = [
        'estado_id' => 'required',
        'ciudad_id' => 'required',
        'estado' => 'required',
        'name' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'direccion' => 'required|max:50',
        'apellido' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'nro_documento' => 'required|numeric|min:5|unique:users',
        'tipo_documento' => 'required',
        'roles_id' => 'required',
        'telefono' => 'required|numeric|min:9',
        'email' => 'required|email|max:50|unique:users',
        'password' => 'required|min:6|max:12',
        'sucursales_id' => 'required',
        'limitacion' => 'required',
    ];

    protected $rul_password_confirm = [
        'password' => 'required|confirmed',
    ];

    public function mount(){

        $this->estados=Estado::all();
        $this->roles=Role::all();
        $this->sucursales=Sucursal::where('status',1)->get();
    }

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
 
    public function render()
    {

      
        return view('livewire.admin.usuarios-create');
    }

    public function save()
    {
        $rules = $this->rules;
        $this->validate($rules);

        if($this->password == $this->password_confirm){
            $usuario = new User();
            $usuario->name = $this->name;
            $usuario->apellido = $this->apellido;
            $usuario->email = $this->email;
            $usuario->nro_documento = $this->nro_documento;
            $usuario->tipo_documento = $this->tipo_documento;
            $usuario->direccion= $this->direccion;
            $usuario->telefono = $this->telefono;
            $usuario->password = Hash::make($this->password);
            $usuario->password_cifrada = Crypt::encryptString($this->password);
            $usuario->ciudad_id = $this->ciudad_id;
            $usuario->estado_id = $this->estado_id;
            $usuario->estado = $this->estado;
            $usuario->sucursal_id = $this->sucursales_id;
            $usuario->limitacion = $this->limitacion;
            if($this->changePrice == "1")   $usuario->changePrice = 'si';
            else $usuario->changePrice = 'no';
            $usuario->apertura = 'no';
            $usuario->save();
            $usuario->roles()->sync($this->roles_id);

            $this->reset(['name','apellido','email','changePrice' ,'telefono','sucursales_id','limitacion','password','password_confirm','nro_documento','tipo_documento','direccion','estado','ciudad_id','estado_id','roles_id']);
            $this->emit('alert','usuario creado correctamente');
        } else{
            $rul_password_conf = $this->rul_password_confirm;
            $this->validate($rul_password_conf);
        }
    }
}
