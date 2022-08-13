<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Empresa;
use App\Models\Producto_venta;
use Livewire\Component;
use PDF;

class VentasView extends Component
{

    public $venta, $deuda_cliente, $pago_cliente, $estado_entrega, $telefono_cliente, $fecha_creacion, $tipo_pago, $factura_nro, $nombre_cliente, $apellido_cliente, $tipo_doc_cliente, $doc_cliente, $nombre_usuario, $apellido_usuario, $sucursal, $subtotal, $descuento, $impuesto, $total;
    public $iva = 0.15;

    public $isopen = false;

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }
    public function mount(){
       
    }
    public function render()
    {

        $this->fecha_creacion = $this->venta->fecha;
        $this->factura_nro = $this->venta->id;
        $this->nombre_cliente = $this->venta->cliente->nombre;
        $this->apellido_cliente = $this->venta->cliente->apellido;
        $this->tipo_doc_cliente = $this->venta->cliente->tipo_documento;
        $this->doc_cliente = $this->venta->cliente->nro_documento;
        $this->nombre_usuario = $this->venta->user->name;
        $this->apellido_usuario = $this->venta->user->apellido;
        $this->sucursal = $this->venta->sucursal->nombre;
        $this->subtotal = $this->venta->subtotal;
        $this->descuento = $this->venta->descuento;
      //  $this->impuesto = $this->venta->impuesto;
        $this->total = $this->venta->total;
        $this->tipo_pago = $this->venta->tipo_pago;
        $this->telefono_cliente = $this->venta->cliente->telefono;
        $this->estado_entrega = $this->venta->estado_entrega;
        $this->pago_cliente= $this->venta->total_pagado_cliente;
        $this->deuda_cliente= $this->venta->deuda_cliente;
        
        $productos = Producto_venta::where('venta_id',$this->venta->id)->get();
        return view('livewire.ventas.ventas-view',compact('productos'));
    }


    public function export_pdf($comprobante){

        $productos = Producto_venta::where('venta_id',$this->venta->id)->get();
        $this->empresa = Empresa::first();
        
        if ($this->tipo_pago == "1"){
            $data = [
                'cliente_nombre' => $this->nombre_cliente." ".$this->apellido_cliente,
                'cliente_documento' =>$this->doc_cliente,
                'cliente_telefono' =>$this->telefono_cliente,
                'usuario' => $this->nombre_usuario." ".$this->apellido_usuario,
                'fecha_actual' => $this->fecha_creacion,
                'venta_nro' => $this->factura_nro,
                'collection' => $productos,
                'empresa' => $this->empresa,
                'estado_entrega' => $this->estado_entrega,
                'descuento' => $this->descuento,
                'subtotal' => $this->subtotal,
                'total' => $this->total,
                'productos' => $productos,
                'iva' => $this->iva,

            ];
            if($comprobante=='factura') $pdf = PDF::loadView('ventas.view_FacturacionContado',$data)->output();
            else $pdf = PDF::loadView('ventas.view_TicketContado',$data)->output();
        }
        else{
            $data = [
                'cliente_nombre' => $this->nombre_cliente." ".$this->apellido_cliente,
                'cliente_documento' =>$this->doc_cliente,
                'cliente_telefono' =>$this->telefono_cliente,
                'usuario' => $this->nombre_usuario." ".$this->apellido_usuario,
                'fecha_actual' => $this->fecha_creacion,
                'venta_nro' => $this->factura_nro,
                'collection' => $productos,
                'empresa' => $this->empresa,
                'estado_entrega' => $this->estado_entrega,
                'descuento' => $this->descuento,
                'subtotal' => $this->subtotal,
                'pagado' => $this->pago_cliente,
                'total' => $this->total,
                'productos' => $productos,
                'deuda' => $this->deuda_cliente,
                'iva' => $this->iva,
            ];
            if($comprobante=='factura') $pdf = PDF::loadView('ventas.view_FacturacionCredito',$data)->output();
           else $pdf = PDF::loadView('ventas.view_TicketCredito',$data)->output();
        }

        return response()->streamDownload(
            fn () => print($pdf),
           "Factura.pdf"
            );

    }
}
