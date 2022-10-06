<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\MovimientoCaja;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AperturaCaja extends Component
{
    public $aperturo,$cerro,$user_auth,$sucursales,$cajas = [],$observaciones,$sucursal_id="",$caja_id="",$monto_bolivares,$monto_dolares,$sucursal_select,$limitacion;

    protected $listeners = ['render' => 'render'];
    
    public function render()
    {

        $user =  Auth::user();
        $user_auth = User::where('id',$user->id)->first(); 

        if($user_auth->limitacion == '1') {
            $this->limitacion = 'no';

            $this->sucursales = Sucursal::all();
        }
        else {
            $this->limitacion = 'no';
            $this->sucursal_select = $user_auth->sucursal->nombre;
            $this->sucursal_id = $user_auth->sucursal->sucursal_id;
        }

        if($user_auth->apertura == 'si'){
            $this->aperturo = 'si';
            
            $movimiento = MovimientoCaja::where('tipo_movimiento','4')
            ->where('user_id',$user->id)
            ->firstOrFail();

        //$movimiento= $movimient->toArray();


          //  dd($movimiento->observacion);
        } 
        else{
            $this->aperturo = 'no';
            $movimiento = [];
        } 

        

       // dd($movimiento);

        return view('livewire.apertura-caja',compact('movimiento'));
    }

    public function updatedSucursalId($value)
    {
        $sucursal_select = Sucursal::find($value);
        $this->cajas = $sucursal_select->cajas;
      
    }

    public function aperturar(){
        //validaciones
        $user =  Auth::user();
        $user_auth = User::where('id',$user->id)->first(); 
       
        $user_auth->update([
            'apertura' => "si",
        ]);


       $caja = Caja::where('id',$this->caja_id)->first();

        $caja->update([
            'saldo_dolares' => $this->monto_dolares,
            'saldo_bolivares' => $this->monto_bolivares,
        ]);

        $movimiento = new MovimientoCaja();
        $movimiento->fecha = Carbon::now();
        $movimiento->tipo_movimiento = 4;
        $movimiento->cantidad = $this->monto_bolivares;
        $movimiento->observacion = $this->observaciones;
        $movimiento->user_id = $user_auth->id;
        $movimiento->sucursal_id = $this->sucursal_id;
        $movimiento->caja_id = $this->caja_id;
        $movimiento->estado = 'caja aperturada en bolivares';
        $movimiento->save();

        $movimiento = new MovimientoCaja();
        $movimiento->fecha = Carbon::now();
        $movimiento->tipo_movimiento = 4;
        $movimiento->cantidad = $this->monto_dolares;
        $movimiento->observacion = $this->observaciones;
        $movimiento->user_id = $user_auth->id;
        $movimiento->sucursal_id = $this->sucursal_id;
        $movimiento->caja_id = $this->caja_id;
        $movimiento->estado = 'caja aperturada en dólares';
        $movimiento->save();

   

        return redirect(request()->header('Referer'));
    }
}
