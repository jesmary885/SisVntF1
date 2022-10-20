<?php

namespace App\Http\Livewire\Productos;

use App\Exports\KardexExport;
use App\Models\Movimiento;
use App\Models\Producto;
use Livewire\Component;
Use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductosHistorial extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public $search, $fecha_inicio, $fecha_fin, $movimientos_totales,$buscador;

    public function render()
    {
        $fecha_inicioo = date("Y-m-d",strtotime($this->fecha_inicio));
        $fecha_finn = date("Y-m-d",strtotime($this->fecha_fin));

        $productos=Producto::all();


            if($this->buscador == 0){
        

                $array = Movimiento::whereHas('producto',function(Builder $query){
                    $query->where('nombre','LIKE', '%' . $this->search . '%')
                ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin]);
            })->paginate(15);
    
                $this->item_buscar = "el nombre del producto a buscar";
            }


            elseif ($this->buscador == 1){
                $array = Movimiento::whereHas('producto',function(Builder $query){
                    $query->where('cod_barra','LIKE', '%' . $this->search . '%')
                ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin]);})               
                ->paginate(10);
    
                $this->item_buscar = "el código de barra del producto a buscar";
            }
    
            else{

                $array = Movimiento::whereHas('user',function(Builder $query){
                    $query->where('name','LIKE', '%' . $this->search . '%')
                ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin]);})               
                ->paginate(10);

                $this->item_buscar = "el nombre del usuario asociado a los movimientos";
    
            }

        return view('livewire.productos.productos-historial',compact('array'));
    }

    public function export(){

        
        $fecha_inicio = date("d-m-Y",strtotime($this->fecha_inicio));
        $fecha_fin = date("d-m-Y",strtotime($this->fecha_fin));
        $movimientos_totales = Movimiento::whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])->get();

        return Excel::download(new KardexExport($movimientos_totales,$fecha_inicio,$fecha_fin), 'Kardex.xlsx');


    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">Para generar el reporte de los movimientos del equipo, ingrese el periodo de fechas en que desee generar el reporte y haga click al boton "<i class="fas fa-check"></i>" ubicado al lado del equipo que desea seleccionar');
    }
    
}
