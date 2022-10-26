<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use App\Models\Sucursal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDF;

class AperturaCaja extends Component
{
    public $aperturo,$cerro,$user_auth,$sucursales,$cajas = [],$observaciones,$sucursal_id="",$caja_id="",$monto_bolivares,$monto_dolares,$sucursal_select,$limitacion;
    public $movimiento,$array,$array_cambios,$array_compras,$inicial_bolivares,$inicial_dolares;

    protected $listeners = ['render' => 'render'];

    protected $rules = [
        'monto_bolivares' => 'required',
        'monto_dolares'=>'required',
        'sucursal_id' => 'required',
        'caja_id' => 'required',
     ];
    
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
            
            $this->movimiento = MovimientoCaja::latest()
                ->with('caja')
                ->where('tipo_movimiento','4')
                ->where('user_id',$user->id)
                ->take(2)
                ->get();

            $this->inicial_bolivares = MovimientoCaja::latest()
                ->with('caja')
                ->where('tipo_movimiento','4')
                ->where('estado','caja aperturada en bolivares')
                ->where('user_id',$user->id)
                ->first();

            $this->inicial_dolares = MovimientoCaja::latest()
                ->with('caja')
                ->where('tipo_movimiento','4')
                ->where('estado','caja aperturada en dólares')
                ->where('user_id',$user->id)
                ->first();

            $fecha_cierre = $user_auth->ultima_fecha_cierre;
            $fecha_apertura = date("Y-m-d H:i:00",strtotime($user_auth->ultima_fecha_apertura));
            $user_idd = $user->id;
            $sucursal_id = $user_auth->ultima_sucursal_id_apertura;
            $caja_id = $user_auth->ultima_caja_id_apertura;

            $movimientos_pagos = DB::select('SELECT sum(pv.monto) as quantity, mp.nombre as metodo_nombre from pago_ventas pv
            right join metodo_pagos mp on pv.metodo_pago_id = mp.id
            inner join ventas v on pv.venta_id=v.id  where v.user_id = :user_idd AND v.caja_id = :caja_id AND v.sucursal_id = :sucursal_id AND v.created_at >= :fecha_apertura
            group by mp.nombre order by sum(pv.monto) desc',array('user_idd' => $user_idd,'caja_id' => $caja_id,'sucursal_id' => $sucursal_id,'fecha_apertura' => $fecha_apertura));

            $movimientos_cambios = DB::select('SELECT sum(v.vuelto) as quantity_vueltos, mp.nombre as metodo_nombre from metodo_pagos mp 
            inner join ventas v on v.metodo_pago_vuelto_id = mp.id AND v.user_id = :user_idd AND v.caja_id = :caja_id AND v.sucursal_id = :sucursal_id AND v.created_at >= :fecha_apertura
            group by mp.nombre order by sum(v.vuelto) desc',array('user_idd' => $user_idd,'caja_id' => $caja_id,'sucursal_id' => $sucursal_id,'fecha_apertura' => $fecha_apertura));

            $movimientos_compras = DB::select('SELECT sum((c.total - c.deuda_a_proveedor)) as quantity, mp.nombre as metodo_nombre from compras c
            right join metodo_pagos mp on c.metodo_pago_id = mp.id where c.user_id = :user_idd AND c.caja_id = :caja_id AND c.sucursal_id = :sucursal_id AND c.created_at >= :fecha_apertura
            group by mp.nombre',array('user_idd' => $user_idd,'caja_id' => $caja_id,'sucursal_id' => $sucursal_id,'fecha_apertura' => $fecha_apertura));

            $data=json_encode($movimientos_pagos);
            $data_cambios=json_encode($movimientos_cambios);
            $data_compras=json_encode($movimientos_compras);
            
            $this->array = json_decode($data, true);
            $this->array_cambios = json_decode($data_cambios, true);
            $this->array_compras = json_decode($data_compras, true);
            
        } 
        else{
            $this->aperturo = 'no';
            $this->movimiento = [];
            $this->array = [];
            $this->array_cambios = [];
            $this->array_compras = [];
            $this->inicial_bolivares = [];
            $this->inicial_dolares = [];
        } 

        return view('livewire.apertura-caja');
    }

    public function updatedSucursalId($value)
    {
        $sucursal_select = Sucursal::find($value);
        $this->cajas = $sucursal_select->cajas;
      
    }

    public function aperturar(){
        //validaciones
        $rules = $this->rules;
        $this->validate($rules);

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

    public function export(){

        $empresa = Empresa::first();
        $today = date('d-m-Y  h:i:s');

        $data = [
            'caja' => $this->movimiento[0]['caja']['nombre'],
            'empresa' =>$empresa,
            'sucursal' =>$this->movimiento[0]['caja']['sucursal']['nombre'],
            'cajero' => auth()->user()->name." ".auth()->user()->apellido,
            'fecha_apertura' => date("d-m-Y h:i:s",strtotime($this->movimiento[0]['created_at'])) ,
            'fecha_cierre' => $today,
            'array' =>$this->array,
            'array_cambios' =>$this->array_cambios,
            'array_compras' => $this->array_compras,
            'inicial_bolivares' => $this->inicial_bolivares,
            'inicial_dolares' => $this->inicial_dolares,
            'movimiento' => $this->movimiento[0],
            ];

        $pdf = PDF::loadView('reportes.cierre-de-caja',$data)->output();

             //GENERANDO PDF
       
        return response()->streamDownload(fn () => print($pdf),
            "Reporte cierre de caja.pdf"
        );
            
    }
}
