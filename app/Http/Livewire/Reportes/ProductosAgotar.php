<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class ProductosAgotar extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $productos = Producto::where('estado','Habilitado')
            ->whereColumn('cantidad','<=', 'stock_minimo')
            ->paginate(10);

        $cant = $productos->count();

        return view('livewire.reportes.productos-agotar',compact('productos','cant'));
    }

    public function export_pdf(){
        $fecha_actual = date('d-m-Y');
        $usuario_nombre =  auth()->user()->name;
        $usuario_apellido =  auth()->user()->apellido;

        $productos = Producto::where('estado','Habilitado')
            ->whereColumn('cantidad','<=', 'stock_minimo')
            ->get();

        $cant = $productos->count();

        $data = [
            'total' => $cant,
            'fecha' => $fecha_actual,
            'usuario_nombre' => $usuario_nombre,
            'usuario_apellido' => $usuario_apellido,
            'productos' => $productos
        ];

       $pdf = PDF::loadView('reportes.productos_agotarse_pdf',$data)->output();

       return response()->streamDownload(
        fn () => print($pdf),
       "Productos por agotarse.pdf"
        );
    }
}
