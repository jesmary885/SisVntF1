<?php

namespace App\Http\Livewire\Productos;

use App\Models\Moneda;
use App\Models\Producto_lote;
use App\Models\Producto_sucursal;
use App\Models\Proveedor;
use App\Models\tasa_dia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductosLoteEdit extends Component
{
    public $isopen = false,$lote,$tasa_dia,$moneda_nombre,$moneda_simbolo,$monedas, $moneda_id= "";

    public $proveedor_id ="", $proveedores, $nombre, $cod_barra,$nro_lote, $fecha_vencimiento,$observaciones,$status,$vencimiento = "No",$sucursal_lote_productos, $sucursal_lote_product=[];
    public $utilidad_letal, $utilidad_mayor, $margen_letal, $margen_mayor, $precio_entrada, $precio_letal, $precio_mayor,$act_utilidades="1", $act_old_rol=0;

    public function mount(){

        $this->sucursal_lote_productos = Producto_sucursal::where('producto_id',$this->lote->producto_id)
            ->where('lote',$this->lote->lote)
            ->get();

        $this->precio_letal = $this->lote->precio_letal;
        $this->utilidad_letal = $this->lote->utilidad_letal;
        $this->precio_entrada = $this->lote->precio_entrada;
        $this->precio_mayor = $this->lote->precio_mayor;
        $this->margen_mayor = $this->lote->utilidad_mayor;
        $this->margen_letal = $this->lote->margen_letal;
        $this->utilidad_mayor = $this->lote->utilidad_mayor;
        $this->observaciones = $this->lote->observaciones;
        $this->status = $this->lote->status;
        $this->otro = $this->lote->producto;
        $this->nombre = $this->lote->producto->nombre;
        $this->cod_barra = $this->lote->producto->cod_barra;
        $this->nro_lote = $this->lote->lote;
        $this->proveedores=Proveedor::all();
        $this->proveedor_id = $this->lote->proveedor_id;
        
       if($this->lote->producto->vencimiento == "No") {
            $this->vencimiento = "No";
            $this->fecha_vencimiento = "null";
        }
        else {
            $this->vencimiento = "Si";
            $this->fecha_vencimiento = $this->lote->fecha_vencimiento;
        }
        $this->monedas = Moneda::all();
    }

    public function render()
    {
        if($this->precio_entrada != ''){
            /*if($this->act_old_rol == '1'){
                $this->act_old_rol = 0;
                $this->reset(['precio_letal','margen_letal','precio_mayor','margen_mayor','precio_entrada','utilidad_letal','utilidad_mayor','fecha_vencimiento']);
            }*/

            if($this->act_utilidades == 1){
                if($this->margen_letal != ''){
                    $this->reset(['precio_letal','utilidad_letal']);
                    $this->precio_letal = round(($this->precio_entrada / (1 - ($this->margen_letal / 100))),2);
                    $this->utilidad_letal = round(($this->precio_letal - $this->precio_entrada),2);
                }
                if($this->margen_mayor != ''){
                    $this->reset(['precio_mayor','utilidad_mayor']);
                    $this->precio_mayor = round(($this->precio_entrada / (1- ($this->margen_mayor / 100))),2);
                    $this->utilidad_mayor = round(($this->precio_mayor - $this->precio_entrada),2);
                }
            }
        
            elseif($this->act_utilidades == 2){
                if($this->utilidad_letal != ''){
                    $this->reset(['precio_letal','margen_letal']);
                    $this->precio_letal = round(($this->precio_entrada + $this->utilidad_letal),2);
                    $this->margen_letal = round((($this->utilidad_letal / $this->precio_letal) * 100),2);
                }
                if($this->utilidad_mayor != ''){
                    $this->reset(['precio_mayor','margen_mayor']);
                    $this->precio_mayor = round(($this->precio_entrada + $this->utilidad_mayor),2);
                    $this->margen_mayor = round((($this->utilidad_mayor / $this->precio_mayor) * 100),2);
                }
            }
        }

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
        return view('livewire.productos.productos-lote-edit');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function update(){

        if($this->fecha_vencimiento != "null") $fecha_vencimiento = Carbon::parse($this->fecha_vencimiento);
        else $fecha_vencimiento = null;

        if($this->moneda_id == '1') $tasa_dia = 1;
        else $tasa_dia = tasa_dia::where('moneda_id',$this->moneda_id)->first()->tasa;         

        $this->lote->update([
            "proveedor_id"      => $this->proveedor_id,
            "producto_id"       => $this->lote->producto_id,
            "fecha_vencimiento" => $fecha_vencimiento,
            "precio_entrada"    => $this->precio_entrada*$tasa_dia,
            "precio_letal"      => $this->precio_letal*$tasa_dia,
            "precio_mayor"      => $this->precio_mayor*$tasa_dia,
            "utilidad_letal"    => $this->utilidad_letal*$tasa_dia,
            "margen_letal"      => $this->margen_letal,
            "utilidad_mayor"    => $this->utilidad_mayor*$tasa_dia,
            "margen_mayor"      => $this->margen_mayor,
            "observaciones"     => $this->observaciones,
        ]);

        $this->emitTo('productos.productos-lote','render');
        $this->emit('alert','Lote modificado correctamente');
    }
}
