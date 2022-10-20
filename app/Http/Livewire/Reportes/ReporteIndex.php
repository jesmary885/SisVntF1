<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Sucursal;
use Carbon\Carbon;
use Livewire\Component;

class ReporteIndex extends Component
{
    public $vista, $fecha_inicio, $fecha_fin, $sucursal_id,$sucursales,$sucursal_select;

    protected $rules = [
        'fecha_inicio' => 'required',
        'fecha_fin' => 'required',
        'sucursal_id' => 'required',
     ];

    
    public function mount(){
        $this->sucursales = Sucursal::all();
    }

    public function render()
    {
        return view('livewire.reportes.reporte-index');
    }

    public function buscar(){

        $rules = $this->rules;
        $this->validate($rules);
        
        $sucursal_id = $this->sucursal_id;
        $fecha_inicio = Carbon::parse($this->fecha_inicio)->format('d-m-Y');
        $fecha_fin = Carbon::parse($this->fecha_fin)->format('d-m-Y');

        if($this->vista == 'productos') return redirect()->route('productos.reportes',compact('sucursal_id','fecha_inicio','fecha_fin'));
        if($this->vista == 'cajas') return redirect()->route('cajas.reportes',compact('sucursal_id','fecha_inicio','fecha_fin'));
        else return redirect()->route('ventas.reportes',compact('sucursal_id','fecha_inicio','fecha_fin'));
    }
}
