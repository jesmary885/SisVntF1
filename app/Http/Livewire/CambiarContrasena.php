<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CambiarContrasena extends Component
{
   
    public $password,$old_password,$password_confirmation;

    protected $rules = [
        'password' => 'required|min:8|confirmed',
        'old_password' => 'required|min:8',
        'password_confirmation' => 'required|min:8',
    ];

    public function render()
    {
        return view('livewire.cambiar-contrasena');
    }

    public function update_password(){

        $rules = $this->rules;
        $user = Auth::user();
        $usuario_auth = User::where('id',$user->id)->first();
        $this->validate($rules);

        if (Hash::check(($this->old_password), ($user->password))) {
            $usuario_auth->update([
                'password' => Hash::make($this->password)
                ]);

            $this->emit('alert','Su contraseña ha sido modificada');
             $this->reset('password','old_password','password_confirmation');

        }else{
            $this->emit('alert','Su contraseña ha sido modificada');
            $this->reset('password','old_password','password_confirmation');
        }
    }


}
