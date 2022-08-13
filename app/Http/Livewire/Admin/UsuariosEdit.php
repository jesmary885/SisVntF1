<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ciudad;
use App\Models\Estado;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Crypt;

class UsuariosEdit extends Component
{

    public $estado_id ="",$ciudad_id ="", $roles_id, $sucursales_id = "";
    public $estados, $usuario;
    public $name, $apellido, $sucursales, $changePrice, $limitacion, $roles, $tipo_documento, $nro_documento, $telefono, $email, $ciudades, $estado, $password, $direccion, $password_confirm;

    public $isopen = false;

      
    protected $rules = [
        'estado_id' => 'required',
        'ciudad_id' => 'required',
        'estado' => 'required',
        'name' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'apellido' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'direccion' => 'required|max:50',
        'tipo_documento' => 'required',
        'roles_id' => 'required',
        'telefono' => 'required|numeric|min:9',
        'password' => 'required|min:6|max:12',
        'sucursales_id' => 'required',
        'limitacion' => 'required',
    ];

    protected $rul_password_confirm = [
        'password' => 'required|confirmed',
    ];

  /*  public function updatedCiudadId($value)
    {
        $ciudad_select = Ciudad::find($value);
        $this->estados = $ciudad_select->estados;
    }*/

    public function updatedEstadoId($value)
    {
        $estado_select = Estado::find($value);
        $this->ciudades = $estado_select->ciudades;
    }

    public function mount(){


        $this->tipo_documento = $this->usuario->tipo_documento;
        $this->nro_documento = $this->usuario->nro_documento;
        $this->telefono = $this->usuario->telefono;
        $this->name = $this->usuario->name;
        $this->apellido = $this->usuario->apellido;
        $this->email = $this->usuario->email;
        $this->direccion = $this->usuario->direccion;
        $this->ciudad_id = $this->usuario->ciudad_id;
        $this->estado_id = $this->usuario->estado_id;
        $this->password = Crypt::decryptString($this->usuario->password_cifrada);
        $this->password_confirm = $this->password;
        $this->estado = $this->usuario->estado;
        $this->limitacion = $this->usuario->limitacion;
        if($this->usuario->changePrice == 'no') $this->changePrice = 0;
        elseif($this->usuario->changePrice == 'si') $this->changePrice = 1;
        $this->sucursales_id = $this->usuario->sucursal_id;
        $this->roles_id = $this->usuario->roles->first()->id;
        $this->estados=Estado::all();
        $this->roles=Role::all();
        $this->sucursales=Sucursal::where('status',1)->get();
        $this->ciudades=Ciudad::all();
    }

    public function render()
    {
        return view('livewire.admin.usuarios-edit');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function update(){
        $rules = $this->rules;
        $this->validate($rules);

        $rule_email = [
            'email' => 'required|max:50|email|unique:users,email,' .$this->usuario->id,
        ];

        $rule_documento = [
            'nro_documento' => 'required|min:5|unique:users,nro_documento,' .$this->usuario->id,
        ];

        $this->validate($rule_email);
        $this->validate($rule_documento);

        if($this->changePrice == "1") $changePrice= "si";
        elseif($this->changePrice == "0") $changePrice= "no";
 
        if($this->password == $this->password_confirm){
            $this->usuario->update([
                'name' => $this->name,
                'email' => $this->email,
                'apellido' => $this->apellido,
                'nro_documento' => $this->nro_documento,
                'tipo_documento' => $this->tipo_documento,
                'direccion' => $this->direccion,
                'estado' => $this->estado,
                'telefono' => $this->telefono,
                'password' => Hash::make($this->password),
                'password_encriptada' => Crypt::encryptString($this->password),
                'ciudad_id' => $this->ciudad_id,
                'estado_id' => $this->estado_id,
                'sucursal_id' => $this->sucursales_id,
                'limitacion' => $this->limitacion,
                'changePrice' => $changePrice,
            ]);
            $this->usuario->roles()->sync($this->roles_id);

            $this->reset(['isopen']);
            $this->emitTo('admin.usuarios-index','render');
            $this->emit('alert','Los datos han sido modificados correctamente');
        } else{
            $rul_password_conf = $this->rul_password_confirm;
            $this->validate($rul_password_conf);
        }
    }
}
