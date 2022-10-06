<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\MovimientoCaja;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CierreCaja extends Component
{
    public $movimiento,$user_auth,$observaciones;
    public $isopen = false;

    public function render()
    {

        return view('livewire.cierre-caja');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function cerrar(){

        $this->user_auth =  Auth::user();

        $user = User::where('id',$this->user_auth->id)->first();

        $user->update([
            'apertura' => 'no',
        ]);

        $caja = Caja::where('id',$this->movimiento->caja_id)->first();

        $movimiento_new = new MovimientoCaja();
        $movimiento_new->fecha = Carbon::now();
        $movimiento_new->tipo_movimiento = 5;
        $movimiento_new->cantidad = $caja->saldo_bolivares;
        $movimiento_new->observacion = $this->observaciones;
        $movimiento_new->user_id = $this->user_auth->id;
        $movimiento_new->sucursal_id = $this->movimiento->sucursal_id;
        $movimiento_new->caja_id = $this->movimiento->caja_id;
        $movimiento_new->estado = 'caja cerrada en bolivares';
        $movimiento_new->save();

        $movimiento_new = new MovimientoCaja();
        $movimiento_new->fecha = Carbon::now();
        $movimiento_new->tipo_movimiento = 5;
        $movimiento_new->cantidad = $caja->saldo_dolares;
        $movimiento_new->observacion = $this->observaciones;
        $movimiento_new->user_id = $this->user_auth->id;
        $movimiento_new->sucursal_id = $this->movimiento->sucursal_id;
        $movimiento_new->caja_id = $this->movimiento->caja_id;
        $movimiento_new->estado = 'caja cerrada en dólares';
        $movimiento_new->save();

        $caja->update([
            'saldo_dolares' => "0",
            'saldo_bolivares' => "0",
        ]);
        $this->emitTo('apertura-caja','render');
   

        return redirect(request()->header('Referer'));

        
    }
}
