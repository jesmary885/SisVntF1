<?php

namespace App\Http\Livewire\Reportes;

use App\Exports\TrasladosExport;
use App\Models\Traslado;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReporteTraslado extends Component
{
    public $fecha_fin, $fecha_inicio;

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public function render()
    {
         $traslados = Traslado::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
        ->paginate(10);


        return view('livewire.reportes.reporte-traslado',compact('traslados'));
    }

    public function export(){
        $fecha_inicio = date("d-m-Y", strtotime($this->fecha_inicio));
        $fecha_fin = date("d-m-Y", strtotime($this->fecha_fin));


        $array = Traslado::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])->get();
        
        

        return Excel::download(new TrasladosExport($array,$fecha_inicio,$fecha_fin), 'ReporteTraslados.xlsx');
    }

}
