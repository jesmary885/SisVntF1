<?php

namespace App\Http\Livewire\Admin\Clientes;

use App\Http\Jne\DniFactory;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Estado;
use App\reniec\Reniec;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClientesCreate extends Component
{

    public $estado_id ="",$ciudad_id ="";
    public $nombre, $apellido, $tipo_documento, $nro_documento, $telefono, $email, $ciudades, $direccion, $client, $estados;
    public $isopen = false;
    public $vista, $accion, $cliente;
      
    protected $rules_create = [
        /*'estado_id' => 'required',
        'ciudad_id' => 'required',*/
        'nombre' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'apellido' => 'max:30',
        'direccion' => 'max:50',
        'nro_documento' => 'required|min:5|unique:clientes',
        'tipo_documento' => 'required',
       // 'telefono' => 'min:9',

    ];
    
    protected $rules_mail_edit = [
        'email' => 'max:50|unique:clientes->ignore($this->cliente->id, )',
    ];

    protected $rules_edit = [
       /* 'estado_id' => 'required',
        'ciudad_id' => 'required',*/
        'nombre' => 'required|max:30|regex:/^[\pL\s\-]+$/u',
        'apellido' => 'max:30',
        'direccion' => 'max:50',
        'tipo_documento' => 'required',
      //  'telefono' => 'numeric|min:9',

    ];


    public function updatedEstadoId($value)
    {
        $estado_select = Estado::find($value);
        $this->ciudades = $estado_select->ciudades;
    }

    public function mount(Cliente $cliente){
        if($this->accion=='create'){
            $this->ciudades=[];
        }else{
            $this->ciudades=Ciudad::all();
        }
        
        $this->cliente = $cliente;
        if($cliente){

            $this->tipo_documento = $this->cliente->tipo_documento;
            $this->nro_documento = $this->cliente->nro_documento;
            $this->telefono = $this->cliente->telefono;
            $this->nombre = $this->cliente->nombre;
            $this->apellido = $this->cliente->apellido;
            $this->email = $this->cliente->email;
            $this->direccion = $this->cliente->direccion;
            $this->ciudad_id = $this->cliente->ciudad_id;
            $this->estado_id = $this->cliente->estado_id;
        }
     
        $this->estados=Estado::all();
    }


    public function render()
    {
        return view('livewire.admin.clientes.clientes-create');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function buscar_dni(){
     
            $dni=$this->nro_documento;

           
            
            $factory = new DniFactory();
            $cs = $factory->create();
            $person = $cs->get($dni);

            
          //  dd($person);

            if (!$person) {
               return $this->emit('errorSize','El dni ingresado no se encuentra en los registros del Reniec');
            }

            $persona_reniec = json_encode($person);
            $persona_dni = json_decode($persona_reniec, true);

            $this->nombre = $persona_dni['nombres'];
            $this->apellido = $persona_dni['apellidoPaterno'];

    }

    public function save(){
           

            if($this->accion == 'create')
            {
                $rules_create = $this->rules_create;
                $this->validate($rules_create);
                if($this->email){
                $rule_email = [
                    'email' => 'required|max:50|email|unique:clientes,email,' .$this->cliente->id,
                ];
                $this->validate($rule_email);
                }

                $usuario_auth = Auth::id();

                $cliente = new Cliente();
                $cliente->nombre = $this->nombre;
                $cliente->apellido = $this->apellido;
                if($this->email) $cliente->email = $this->email;
                
                $cliente->nro_documento = $this->nro_documento;
                $cliente->tipo_documento = $this->tipo_documento;
                if($this->direccion) $cliente->direccion= $this->direccion;
                if($this->telefono) $cliente->telefono = $this->telefono;
                if($this->ciudad_id) $cliente->ciudad_id = $this->ciudad_id;
                if($this->estado_id) $cliente->estado_id = $this->estado_id;
                $cliente->user_id = $usuario_auth;
                $cliente->save();

                $this->reset(['nombre','apellido','email','telefono','nro_documento','tipo_documento','direccion','ciudad_id','estado_id','isopen']);
                if ($this->vista == "ventas") $this->emitTo('ventas.venta-facturacion','render');
                else $this->emitTo('admin.clientes.clientes-index','render');

                $this->emit('alert','Cliente creado correctamente');
            }
            else
            {
                $rules_edit = $this->rules_edit;
                $this->validate($rules_edit);

                if($this->email){
                    $rule_email = [
                        'email' => 'required|max:50|email|unique:clientes,email,' .$this->cliente->id,
                    ];

                    $this->validate($rule_email);
                }


                $rule_documento = [
                    'nro_documento' => 'required|min:5|unique:clientes,nro_documento,' .$this->cliente->id,
                ];

                $this->validate($rule_documento);

             //   $validate_email = [Rule$table->dropUnique('users_email_unique');('clientes')->ignore($this->cliente->id, 'id' )];

                $this->cliente->update([
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'email' => $this->email,
                    'nro_documento' => $this->nro_documento,
                    'tipo_documento' => $this->tipo_documento,
                    'direccion' => $this->direccion,
                    'telefono' => $this->telefono,
                    'ciudad_id' => $this->ciudad_id,
                    'estado_id' => $this->estado_id,
                ]);
                $this->reset(['isopen']);
                $this->emitTo('admin.clientes.clientes-index','render');
                $this->emit('alert','Datos modificados correctamente');
            }
    }

}
