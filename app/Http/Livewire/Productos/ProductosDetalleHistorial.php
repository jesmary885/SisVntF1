<?php

namespace App\Http\Livewire\Productos;

use App\Exports\MovimientoExport;
use App\Models\Movimiento;
use App\Models\Movimiento_product_serial;
use App\Models\Producto;
use App\Models\ProductoSerialSucursal;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ProductosDetalleHistorial extends Component
{

    public $producto, $fecha_fin, $fecha_inicio, $vista;

    use WithPagination;
    protected $paginationTheme = "bootstrap";
   
    public function render()
    {

        if($this->vista == 'cod_barra'){
            $movimientos = Movimiento::where('producto_id',$this->producto)
            ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->latest('id')
            ->paginate(5);
        }else{
            $movimientos = Movimiento_product_serial::where('producto_serial_sucursal_id',$this->producto)
            ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])
            ->latest('id')
            ->paginate(5);
        }


        return view('livewire.productos.productos-detalle-historial',compact('movimientos'));
    }

    public function export(){
        $fecha_inicio = date("d-m-Y", strtotime($this->fecha_inicio));
        $fecha_fin = date("d-m-Y", strtotime($this->fecha_fin));
        if($this->vista == 'cod_barra'){
            $producto = Producto::where('id',$this->producto)->first();
            $nombre_producto = $producto->nombre;
            $cod_barra_producto = $producto->cod_barra;

            $array = Movimiento::where('producto_id',$this->producto)
                        ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])->get();
        }else{
            $producto = ProductoSerialSucursal::where('id',$this->producto)->first();
            $nombre_producto = $producto->producto->nombre;
            $cod_barra_producto = $producto->cod_barra;

            $array = Movimiento_product_serial::where('producto_serial_sucursal_id',$this->producto)
                        ->whereBetween('fecha',[$this->fecha_inicio,$this->fecha_fin])->get();
        }
        

        return Excel::download(new MovimientoExport($array,$fecha_inicio,$fecha_fin,$nombre_producto,$cod_barra_producto), 'ReporteMovimientoProducto.xlsx');
    }

}
