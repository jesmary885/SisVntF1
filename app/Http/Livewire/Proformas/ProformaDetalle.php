<?php

namespace App\Http\Livewire\Proformas;

use App\Models\Empresa;
use App\Models\Producto_proforma;
use Livewire\Component;
use PDF;

class ProformaDetalle extends Component
{
    public $proforma, $deuda_cliente, $pago_cliente, $estado_entrega, $telefono_cliente, $fecha_creacion, $tipo_pago, $factura_nro, $nombre_cliente, $apellido_cliente, $tipo_doc_cliente, $doc_cliente, $nombre_usuario, $apellido_usuario, $sucursal, $subtotal, $descuento, $impuesto, $total;
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
        $this->fecha_creacion = $this->proforma->fecha;
        $this->factura_nro = $this->proforma->id;
        $this->nombre_cliente = $this->proforma->cliente->nombre;
        $this->apellido_cliente = $this->proforma->cliente->apellido;
        $this->tipo_doc_cliente = $this->proforma->cliente->tipo_documento;
        $this->doc_cliente = $this->proforma->cliente->nro_documento;
        $this->nombre_usuario = $this->proforma->user->name;
        $this->apellido_usuario = $this->proforma->user->apellido;
        $this->sucursal = $this->proforma->sucursal->nombre;
        $this->subtotal = $this->proforma->subtotal;
        $this->descuento = $this->proforma->descuento;
        $this->impuesto = $this->proforma->impuesto;
        $this->total = $this->proforma->total;
        $this->tipo_pago = $this->proforma->tipo_pago;
        $this->telefono_cliente = $this->proforma->cliente->telefono;
        $this->estado_entrega = $this->proforma->estado_entrega;
        $this->pago_cliente= $this->proforma->total_pagado_cliente;
        $this->deuda_cliente= $this->proforma->deuda_cliente;
        
        $productos = Producto_proforma::where('proforma_id',$this->proforma->id)->get();

        return view('livewire.proformas.proforma-detalle',compact('productos'));
    }

    public function export_pdf(){

        $productos = Producto_proforma::where('proforma_id',$this->proforma->id)->get();
        $this->empresa = Empresa::first();
        
            $data = [
                'cliente_nombre' => $this->nombre_cliente." ".$this->apellido_cliente,
                'cliente_documento' =>$this->doc_cliente,
                'cliente_telefono' =>$this->telefono_cliente,
                'usuario' => $this->nombre_usuario." ".$this->apellido_usuario,
                'fecha_actual' => $this->fecha_creacion,
                'venta_nro' => $this->factura_nro,
                'collection' => $productos,
                'estado_entrega' => $this->estado_entrega,
                'descuento' => $this->descuento,
                'subtotal' => $this->subtotal,
                'impuesto' => $this->impuesto,
                'empresa' => $this->empresa,
                'total' => $this->total,
                'productos' => $productos,
                'iva' => $this->iva,

            ];
             $pdf = PDF::loadView('proformas.view_proforma',$data)->output();
    
        return response()->streamDownload(
            fn () => print($pdf),
           "Proforma.pdf"
            );

    }
}
