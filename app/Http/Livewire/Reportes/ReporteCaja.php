<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\ReporteCaja as ExportsReporteCaja;
use App\Exports\ReporteCajaExport;
use App\Models\Empresa;
use App\Models\MovimientoCaja;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class ReporteCaja extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";


    public $fecha_inicio, $fecha_fin, $sucursal_id, $empresa;

    public function render()
    {
        $sucursal = $this->sucursal_id;

        if($sucursal == 0){

            $movimientos = MovimientoCaja::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
                                            ->where('estado','entregado')
            ->paginate(5);
        }
        else{
            $movimientos = MovimientoCaja::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->where('estado','entregado')
            ->where('sucursal_id',$sucursal)
            ->paginate(5);

        }
        return view('livewire.reportes.reporte-caja',compact('movimientos'));
    }

    public function export_excel(){

        $fecha_inicioo = date("Y-m-d",strtotime($this->fecha_inicio));
        $fecha_finn = date("Y-m-d",strtotime($this->fecha_fin));

        $sucursal = $this->sucursal_id;

        if($sucursal == 0){

            $movimientos = MovimientoCaja::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->where('estado','entregado')
            ->get();
        }
        else{
            $movimientos = MovimientoCaja::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->where('estado','entregado')
            ->where('sucursal_id',$sucursal)
            ->get();

        }

        return Excel::download(new ReporteCajaExport($movimientos,$fecha_inicioo,$fecha_finn), 'MovimientoCajas.xlsx');

    }



    public function export_pdf(){

        $fecha_inicioo = date("Y-m-d",strtotime($this->fecha_inicio));
        $fecha_finn = date("Y-m-d",strtotime($this->fecha_fin));
        $this->empresa = Empresa::first();
        $sucursal = $this->sucursal_id;

        if($sucursal == 0){

            $movimientos = MovimientoCaja::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->where('estado','entregado')
            ->paginate(5);
        }
        else{
            $movimientos = MovimientoCaja::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->where('estado','entregado')
            ->where('sucursal_id',$sucursal)
            ->paginate(5);

        }

        $data = [
            'movimientos' => $movimientos,
            'fecha_inicio' => $fecha_inicioo,
            'fecha_fin' => $fecha_finn,  
            'empresa' => $this->empresa,   
        ];

       $pdf = PDF::loadView('reportes.exportPdfCaja',$data)->output();

       return response()->streamDownload(
        fn () => print($pdf),
       "Reporte_venta.pdf"
        );

    }

}
