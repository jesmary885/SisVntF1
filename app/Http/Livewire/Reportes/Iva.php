<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Empresa;
use App\Models\Moneda;
use App\Models\Sucursal;
use App\Models\tasa_dia;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDF;

class Iva extends Component
{
    public $fecha_inicio, $fecha_fin, $sucursal_id, $ventas_realizadas_e, $total_ventas_e, $total_costos_e, $total_ganancias_e;
    public $tasa_dia,$moneda_nombre,$moneda_simbolo, $fecha_inicioo, $fecha_finn;

    public function mount(){
        $this->fecha_inicioo = date("Y-m-d",strtotime($this->fecha_inicio));
        $this->fecha_finn = date("Y-m-d",strtotime($this->fecha_fin));
    }

    public function render()
    {

        $fecha_actual = date('Y-m-d');

        if(session()->has('moneda')){
            $this->moneda = Moneda::where('nombre',session('moneda'))->first();
            $this->moneda_nombre = session('moneda');
            $this->moneda_simbolo = session('simbolo_moneda');
            if(session('moneda') == "Bolivar") $this->tasa_dia = 1;
            else $this->tasa_dia = tasa_dia::where('moneda_id',$this->moneda->id)->first()->tasa;
        } 
        else{
            $this->moneda = Moneda::where('nombre','Bolivar')->first();
            $this->moneda_nombre = 'Bolivar';
            $this->moneda_simbolo = 'Bs';
            $this->tasa_dia = 1;
        } 

        $sucursal = $this->sucursal_id;

        if($sucursal == 0){
            $total_ventas = DB::select('SELECT sum(v.total_pagado_cliente) as quantity, sum(v.impuesto) as impuesto , sum(v.exento) as exento  from ventas v
            where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa"'
            ,array('fecha_inicioo' => $this->fecha_inicioo,'fecha_finn' => $this->fecha_finn));
    
            $cantidad_ventas = DB::select('SELECT COUNT(*) as cantidad from ventas v
            where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa"'
            ,array('fecha_inicioo' => $this->fecha_inicioo,'fecha_finn' => $this->fecha_finn));
    
            $pagos_metodos = DB::select('SELECT sum(pv.monto) as quantity, mp.nombre as metodo_nombre from pago_ventas pv
            right join metodo_pagos mp on pv.metodo_pago_id = mp.id
            inner join ventas v on pv.venta_id=v.id  where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa"
            group by mp.nombre order by sum(pv.monto) desc',array('fecha_inicioo' => $this->fecha_inicioo,'fecha_finn' => $this->fecha_finn));
        }
        else{
            $total_ventas = DB::select('SELECT sum(v.total_pagado_cliente) as quantity, sum(v.impuesto) as impuesto , sum(v.exento) as exento  from ventas v
            where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa" and :sucursal = v.sucursal_id'
            ,array('fecha_inicioo' => $this->fecha_inicioo,'fecha_finn' => $this->fecha_finn, 'sucursal' => $sucursal));
    
            $cantidad_ventas = DB::select('SELECT COUNT(*) as cantidad from ventas v
            where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa" and :sucursal = v.sucursal_id'
            ,array('fecha_inicioo' => $this->fecha_inicioo,'fecha_finn' => $this->fecha_finn, 'sucursal' => $sucursal));
    
            $pagos_metodos = DB::select('SELECT sum(pv.monto) as quantity, mp.nombre as metodo_nombre from pago_ventas pv
            right join metodo_pagos mp on pv.metodo_pago_id = mp.id
            inner join ventas v on pv.venta_id=v.id  where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa" and :sucursal = v.sucursal_id
            group by mp.nombre order by sum(pv.monto) desc',array('fecha_inicioo' => $this->fecha_inicioo,'fecha_finn' => $this->fecha_finn, 'sucursal' => $sucursal));

        }

        $json = json_encode($total_ventas);
        $json2= json_encode($cantidad_ventas);
        $json3 = json_encode($pagos_metodos);

        $array_ventas = json_decode($json);
        $array_cant_ventas = json_decode($json2);
        $this->array_pago_metodos = json_decode($json3,true);

        $this->total_ventas_ganancias = $array_ventas[0]->quantity;
        $this->total_iva = $array_ventas[0]->impuesto;
        $this->total_exento = $array_ventas[0]->exento;
        $this->total_cant_ventas= $array_cant_ventas[0]->cantidad;

        return view('livewire.reportes.iva');
    }

    public function export_pdf(){
        $empresa = Empresa::first();
        $today = date('d-m-Y  h:i:s');

        if($this->sucursal_id == 0) $sucursal_report = 'Todas las sucursales';
        else {
            $sucursal_report = Sucursal::where('id',$this->sucursal_id)->first()->nombre;
        }

        $data = [
            'empresa' =>$empresa,
            'sucursal' =>$sucursal_report ,
            'cajero' => auth()->user()->name." ".auth()->user()->apellido,
            'array_metodos_pago' =>$this->array_pago_metodos ,
            'total_ventas_ganancias' =>$this->total_ventas_ganancias,
            'total_iva' => $this->total_iva ,
            'total_exento' => $this->total_exento,
            'total_cant_ventas' => $this->total_cant_ventas,
            'fecha' => $today,
            'moneda_simbolo' => $this->moneda_simbolo,
            'tasa_dia' => $this->tasa_dia,
            ];

        $pdf = PDF::loadView('reportes.iva_pdf',$data)->output();

             //GENERANDO PDF
       
        return response()->streamDownload(fn () => print($pdf),
            "Reporte totales@iva_exento_metodos.pdf"
        );
    }
}
