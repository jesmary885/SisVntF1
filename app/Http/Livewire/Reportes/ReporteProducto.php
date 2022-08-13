<?php

namespace App\Http\Livewire\Reportes;

use App\Models\Producto;
use App\Models\Producto_venta;
use App\Models\Venta;
use COM;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReporteProducto extends Component
{

    public $fecha_inicio, $fecha_fin, $sucursal_id;
    
    public function render()
    {
        $fecha_inicioo = date("Y-m-d",strtotime($this->fecha_inicio));
        $fecha_finn = date("Y-m-d",strtotime($this->fecha_fin));
        $sucursal = $this->sucursal_id;

        if($sucursal == 0){
            $productos = DB::select('SELECT p.cod_barra, p.nombre, p.id, p.modelo_id, sum(dv.cantidad) as quantity, md.nombre as modelo_nombre from productos p
             right join modelos md on p.modelo_id = md.id
            inner join producto_ventas dv on p.id=dv.producto_id
            inner join ventas v on dv.venta_id = v.id where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn AND v.estado = "activa"
            group by p.cod_barra, p.nombre, p.id, p.modelo_id, md.nombre order by sum(dv.cantidad) desc limit 5',array('fecha_inicioo' => $fecha_inicioo,'fecha_finn' => $fecha_finn));
        } else{
            $productos = DB::select('SELECT p.cod_barra, p.nombre, p.id, p.modelo_id, sum(dv.cantidad) as quantity, md.nombre as modelo_nombre from productos p
            right join modelos md on p.modelo_id = md.id
            inner join producto_ventas dv on p.id=dv.producto_id
            inner join ventas v on dv.venta_id = v.id where v.fecha BETWEEN :fecha_inicioo AND :fecha_finn and :sucursal = v.sucursal_id AND v.estado = "activa"
            group by p.cod_barra, p.nombre, p.id, p.modelo_id, md.nombre order by sum(dv.cantidad) desc limit 5',array('fecha_inicioo' => $fecha_inicioo,'fecha_finn' => $fecha_finn, 'sucursal' => $sucursal));
        }

         /*$movimientos = DB::select('SELECT p.cod_barra, p.nombre, p.id, p.categoria_id, p.modelo_id, p.marca_id, mc.nombre as marca_nombre, md.nombre as modelo_nombre, c.nombre as categoria_nombre, sum(m.precio_entrada) as precie_entrada, sum(m.precio_salida) as precie_salida, sum(m.cantidad_entrada) as quantity_entrada , sum(m.cantidad_salida) as quantity_salida from productos p
            right join categorias c on p.categoria_id = c.id
            right join modelos md on p.modelo_id = md.id
            right join marcas mc on p.marca_id = mc.id
            inner join movimientos m on p.id=m.producto_id where m.fecha BETWEEN :fecha_inicioo AND :fecha_finn
            group by p.cod_barra, p.nombre, p.id, p.categoria_id, p.modelo_id, p.marca_id, c.nombre, md.nombre, mc.nombre',array('fecha_inicioo' => $fecha_inicioo,'fecha_finn' => $fecha_finn));
       

            $data=json_encode($movimientos);
            $array = json_decode($data, true);*/

        $data=json_encode($productos);
        $array = json_decode($data, true);

      
        if($array){
            foreach($array as $arrays){
                $puntos[]=['name' => $arrays['modelo_nombre'] , 'y' => $arrays['quantity']];
                $data2 = json_encode($puntos);
            }

        }
        else{
            $puntos[]="";
            $data2 = json_encode($puntos);
        }

        
        return view('livewire.reportes.reporte-producto',compact('array','data2'));
    }
}
