<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\MovimientoCaja;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $fecha_cierre = $user_auth->ultima_fecha_cierre;
            $fecha_apertura = date("Y-m-d H:i:00",strtotime($user_auth->ultima_fecha_apertura));
            $user_idd = $user->id;
            $sucursal_id = $user_auth->ultima_sucursal_id_apertura;
            $caja_id = $user_auth->ultima_caja_id_apertura;

            //dd( $fecha_apertura);

          /* $movimientos_pagos = DB::select('SELECT sum(pv.monto) as quantity, mp.nombre as metodo_nombre from pago_ventas pv
                right join metodo_pagos mp on pv.metodo_pago_id = mp.id
                inner join ventas v on pv.venta_id=v.id  where v.created_at > :fecha_cierre AND v.created_at <= :fecha_apertura AND v.user_id = :user_idd AND v.caja_id = :caja_id AND v.sucursal_id = :sucursal_id
                group by mp.nombre order by sum(pv.monto) desc',array('fecha_cierre' => $fecha_cierre,'fecha_apertura' => $fecha_apertura,'user_idd' => $user_idd,'caja_id' => $caja_id,'sucursal_id' => $sucursal_id));*/

                $movimientos_pagos = DB::select('SELECT sum(pv.monto) as quantity, mp.nombre as metodo_nombre from pago_ventas pv
                right join metodo_pagos mp on pv.metodo_pago_id = mp.id
                inner join ventas v on pv.venta_id=v.id  where v.user_id = :user_idd AND v.caja_id = :caja_id AND v.sucursal_id = :sucursal_id AND v.created_at >= :fecha_apertura
                group by mp.nombre order by sum(pv.monto) desc',array('user_idd' => $user_idd,'caja_id' => $caja_id,'sucursal_id' => $sucursal_id,'fecha_apertura' => $fecha_apertura));

                $data=json_encode($movimientos_pagos);
                $array = json_decode($data, true);

        } 
        else{
            $this->aperturo = 'no';
            $movimiento = [];
            $array = [];
        } 

        return view('livewire.apertura-caja',compact('movimiento','array'));
    }

    public function updatedSucursalId($value)
    {
        $sucursal_select = Sucursal::find($value);
        $this->cajas = $sucursal_select->cajas;
      
    }

    public function aperturar(){
        //validaciones
        $user =  Auth::user();
        $fecha = Carbon::now();
        $user_auth = User::where('id',$user->id)->first(); 
       
        $user_auth->update([
            'apertura' => "si",
            'ultima_fecha_apertura' => $fecha,
            'ultima_caja_id_apertura' => $this->caja_id,
            'ultima_sucursal_id_apertura' => $this->sucursal_id,
        ]);

       $caja = Caja::where('id',$this->caja_id)->first();

        $caja->update([
            'saldo_dolares' => $this->monto_bolivares,
            'saldo_bolivares' => $this->monto_dolares,
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
