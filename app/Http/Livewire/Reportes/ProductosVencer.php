<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Producto;
use App\Models\Producto_lote;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class ProductosVencer extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
        $fecha_actual = date('Y-m-d');
        $fecha_add_mes= date("Y-m-d",strtotime($fecha_actual."+ 1 month"));

        $productos = Producto::select('productos.cod_barra', 'productos.nombre','modelos.nombre as modelo','marcas.nombre as marca','producto_lotes.lote','producto_lotes.fecha_vencimiento')
            ->join("modelos", "modelos.id", "=", "productos.modelo_id")
            ->join("marcas", "marcas.id", "=", "productos.marca_id")
            ->join("producto_lotes", "producto_lotes.producto_id","=","productos.id")
            ->where("producto_lotes.fecha_vencimiento", "<=", $fecha_add_mes)
            ->paginate(10);

        return view('livewire.reportes.productos-vencer',compact('productos'));
    }

    public function export_pdf(){
        $usuario_nombre =  auth()->user()->name;
        $usuario_apellido =  auth()->user()->apellido;

        $fecha_actual = date('Y-m-d');
        $fecha_actual_convert = date('d-m-Y');
        $fecha_add_mes= date("Y-m-d",strtotime($fecha_actual."+ 1 month"));

        $productos = Producto::select('productos.cod_barra', 'productos.nombre','modelos.nombre as modelo','marcas.nombre as marca','producto_lotes.lote','producto_lotes.fecha_vencimiento')
            ->join("modelos", "modelos.id", "=", "productos.modelo_id")
            ->join("marcas", "marcas.id", "=", "productos.marca_id")
            ->join("producto_lotes", "producto_lotes.producto_id","=","productos.id")
            ->where("producto_lotes.fecha_vencimiento", "<=", $fecha_add_mes)
            ->get();

        $data = [
            'fecha' => $fecha_actual_convert,
            'usuario_nombre' => $usuario_nombre,
            'usuario_apellido' => $usuario_apellido,
            'productos' => $productos,
        ];

       $pdf = PDF::loadView('reportes.productos_por_vencer_pdf',$data)->output();

       return response()->streamDownload(
        fn () => print($pdf),
       "Productos por vencer.pdf"
        );
    }
}
