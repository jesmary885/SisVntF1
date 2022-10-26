<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Caja;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use PDF;
Use Livewire\WithPagination;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\ProductoSerialSucursal;
use App\Models\Proforma;
use App\Models\Sucursal;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Metodo_pago;
use App\Models\Moneda;
use App\Models\Pago_venta;
use App\Models\tasa_dia;
use Illuminate\Support\Facades\Mail;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class VentasCart extends Component
{
    use WithPagination;

    public $publico_general = 1, $sucursal,$caja, $caja_detalle, $sucursal_detalle,$producto,$cambio,$moneda_actual,$tasa_dia,$moneda_nombre,$moneda_simbolo;
    public $cash_received,$tipo_pago = "Contado",$tipo_comprobante,$send_mail,$imprimir,$ticket = 0;
    public $metodo_pago, $total, $client, $search;
    public $cliente_select, $total_venta, $pago_cliente, $deuda_cliente, $descuento, $estado_entrega = "Entregado",$subtotal,$proforma;
    public $siguiente_venta = 0, $monto1, $monto2, $monto3, $monto4, $monto5,$metodo_id_1,$metodo_id_2,$metodo_id_3,$metodo_id_4,$metodo_id_5,$vuelto=0, $monto_vuelto, $metodo_cambio_id;
    public $iva, $carrito,$valor, $iva_empresa,$cant_metodos = 1,$metodos;
    public $descuento_total = 0,$empresa, $other_method;

    protected $listeners = ['render' => 'render'];

    protected $paginationTheme = "bootstrap";

    public $rules = [
        'tipo_pago' => 'required',
        'estado_entrega' => 'required',
        'cliente_select' => 'required',
        'cant_metodos' => 'required',
        'monto1' => 'required',
        'metodo_id_1' => 'required'
    ];

    public $rules_cant_pago_2 = [
        'monto2' => 'required',
        'metodo_id_2' => 'required'
    ];

    public $rules_cant_pago_3 = [
        'monto2' => 'required',
        'metodo_id_2' => 'required',
        'monto3' => 'required',
        'metodo_id_3' => 'required'
    ];

    public $rules_cant_pago_4 = [
        'monto2' => 'required',
        'metodo_id_2' => 'required',
        'monto3' => 'required',
        'metodo_id_3' => 'required',
        'monto4' => 'required',
        'metodo_id_4' => 'required'
    ];

    public $rules_cant_pago_5 = [
        'monto2' => 'required',
        'metodo_id_2' => 'required',
        'monto3' => 'required',
        'metodo_id_3' => 'required',
        'monto4' => 'required',
        'metodo_id_4' => 'required',
        'monto5' => 'required',
        'metodo_id_5' => 'required'
    ];

    public $rule_credito = [
        'pago_cliente' => 'required',
    ];

    public $rule_imprimir = [
        'tipo_comprobante' => 'required',
    ];

    public function updatingSearch(){
        $this->resetPage();
    }

    public function updatedTipoPago($value){
        if ($value == 1) {
            $this->resetValidation([
                'deuda_cliente', 'pago_cliente'
            ]);
        }
    } 

    public function destroy(){
        Cart::destroy();
        $this->emitTo('ventas-seleccion-productos','render');
    }

    public function delete($rowID){
        Cart::remove($rowID);
        $this->emitTo('ventas-seleccion-productos','render');
    }

    public function mount()
    {
        $this->client = Cliente::where('id','1')->first();
        $this->cliente_select = $this->client->nombre." ".$this->client->apellido;
        $this->metodos = Metodo_pago::all();
        $this->empresa = Empresa::first();
        $this->iva_empresa = $this->empresa->impuesto;
        $this->caja_detalle = Caja::where('id',$this->caja)->first();
        $this->sucursal_detalle = Sucursal::where('id',$this->sucursal)->first();
    }

    public function select_u($cliente_id){
        $this->client = Cliente::where('id',$cliente_id)->first();
        $this->cliente_select = $this->client->nombre." ".$this->client->apellido;
    }

    public function render()
    {
        if($this->publico_general == '1') {
            $this->client = Cliente::where('id','1')->first();
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

        $caracter=",";
        $this->subtotal = (str_replace($caracter,"",Cart::subtotal())) - $this->descuento;
        $subt = 0;

        foreach (Cart::content() as $item) {
            if($item->options['exento'] == "No"){
                $subt = $subt + $item->price;
            }
            else{
                $subt = $subt + 0; 
            }

            if($item->options['descuento'] != "null"){
                $this->descuento_total = $this->descuento_total + $item->options['descuento'];
            }

        }

        $this->iva= ($this->empresa->impuesto / 100) * $subt;

        if($this->descuento != null){
            $this->descuento_total = ($this->subtotal  * $this->descuento / 100) + $this->descuento_total;
            $this->total_venta = ($this->subtotal  - $this->descuento_total) + $this->iva;
        }
        else{
            $this->total_venta = ($this->subtotal +  $this->iva) - $this->descuento_total;
        } 
       
        if($this->cash_received != null && $this->other_method == null) $this->cambio = $this->cash_received - $this->total_venta;
        elseif($this->cash_received != null && $this->other_method != null) $this->cambio = (($this->cash_received + $this->other_method) - $this->total_venta);
        else $this->cambio = 0;

        if($this->search != ''){
            $cliente = Cliente::where('nombre', 'LIKE', '%' . $this->search . '%')
                ->orwhere('apellido', 'LIKE', '%' . $this->search . '%')
                ->orwhere('nro_documento', 'LIKE', '%' . $this->search . '%')
                ->first();
                
            if($cliente)$cliente=$cliente;
            else $cliente = 0;
        }
        else{
            $cliente = Cliente::where('id', '1')
            ->first();
        }

        return view('livewire.ventas.ventas-cart',compact('cliente'));
    }


    public function save(){
       
        $rules = $this->rules;
        $this->validate($rules);
        
        if ($this->tipo_pago == "2"){
            $rule_credito = $this->rule_credito;
            $this->validate($rule_credito);   
        }

        if($this->cant_metodos == "2"){
            $rules_cant_pago_2 = $this->rules_cant_pago_2;
            $this->validate($rules_cant_pago_2);   
        }

        if($this->cant_metodos == "3"){
            $rules_cant_pago_3 = $this->rules_cant_pago_3;
            $this->validate($rules_cant_pago_3);   
        }

        if($this->cant_metodos == "4"){
            $rules_cant_pago_4 = $this->rules_cant_pago_4;
            $this->validate($rules_cant_pago_4);   
        }

        if($this->cant_metodos == "5"){
            $rules_cant_pago_5 = $this->rules_cant_pago_5;
            $this->validate($rules_cant_pago_5);   
        }

        if ($this->imprimir == "1"){
            $rule_imprimir = $this->rule_imprimir;
            $this->validate($rule_imprimir);   
        }
 
        $user_auth =  auth()->user()->id;

        if($this->estado_entrega == "1") $entrega = 'Entregado'; else
        $entrega = 'Por entregar';
 
        //PROFORMA
        if($this->proforma == 'proforma'){           
            $proform = new Proforma();
            $proform->user_id = $user_auth;
            $proform->cliente_id = $this->client->id;
            $proform->fecha = date('Y-m-d');
            $proform->tipo_pago = $this->tipo_pago;
            $proform->metodo_pago = $this->metodo_pago;
            if ($this->tipo_pago == "2"){
                $proform->total_pagado_cliente = $this->pago_cliente;
                $proform->deuda_cliente = $this->total_venta - $this->pago_cliente;
            }
            else{
                $proform->total_pagado_cliente = $this->total_venta;
                $proform->deuda_cliente = "0";
            }
            $proform->subtotal =  $this->subtotal;
            $proform->total = $this->total_venta;
            $proform->sucursal_id = $this->sucursal;
            $proform->estado_entrega = $entrega;
            $proform->descuento = $this->descuento_total;
            $proform->estado='activa';
            $proform->save();

            foreach (Cart::content() as $item) {
        
                $proform->producto_proformas()->create([
                    'proforma_id' => $proform->id,
                    'producto_id'=> $item->id,
                    'precio' => $item->price,
                    'cantidad' => $item->qty,
                ]);
            }

        }
        //VENTA
        else
        {
            $caja = Caja::where('id',$this->caja)->first();
            $efectivo_dls_decrec = 0;
            $efectivo_bs_decrec = 0;

            //REGISTRANDO VENTA EN TABLA DE VENTAS
            $venta = new Venta();
            $venta->user_id = $user_auth;
            $venta->cliente_id = $this->client->id;
            $venta->fecha = date('Y-m-d');
            $venta->tipo_pago = $this->tipo_pago;
            if ($this->tipo_pago == "Credito"){
                $venta->total_pagado_cliente = $this->pago_cliente;
                $venta->deuda_cliente = $this->total_venta - $this->pago_cliente;
            }
            else{
                $venta->total_pagado_cliente = $this->total_venta;
                $venta->deuda_cliente = "0";
            }
            if($this->vuelto == 1){
                $venta->vuelto =  $this->monto_vuelto;
                $venta->metodo_pago_vuelto_id =  $this->metodo_cambio_id;
                if($this->metodo_cambio_id == 3) $efectivo_bs_decrec = $this->monto_vuelto;
                if($this->metodo_cambio_id == 4) $efectivo_dls_decrec = $this->monto_vuelto;
            }
            $venta->subtotal =  $this->subtotal;
            $venta->total = $this->total_venta;
            $venta->sucursal_id = $this->sucursal;
            $venta->caja_id = $this->caja;
            $venta->estado_entrega = $this->estado_entrega;
            $venta->descuento = $this->descuento_total;
            $venta->impuesto=$this->iva;
            $venta->estado='activa';
            $venta->save();

            //REGISTRO EN PAGO_VENTAS

            if($this->cant_metodos == 1) {
                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto1;
                $pago_venta->metodo_pago_id = $this->metodo_id_1;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                if($this->metodo_id_1 == 3){
                    $this->caja_detalle->update([
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto1) - $efectivo_bs_decrec,
                    ]);
                }

                if($this->metodo_id_1 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto1) - $efectivo_dls_decrec,
                    ]);
                }
            }
            elseif($this->cant_metodos == 2) {
                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto1;
                $pago_venta->metodo_pago_id = $this->metodo_id_1;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto2;
                $pago_venta->metodo_pago_id = $this->metodo_id_2;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                if($this->metodo_id_2 == 3){
                    $this->caja_detalle->update([
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto2) - $efectivo_bs_decrec,
                    ]);
                }

                if($this->metodo_id_2 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto2) - $efectivo_dls_decrec,
                    ]);
                }
            }
            elseif($this->cant_metodos == 3) {
                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto1;
                $pago_venta->metodo_pago_id = $this->metodo_id_1;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto2;
                $pago_venta->metodo_pago_id = $this->metodo_id_2;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto3;
                $pago_venta->metodo_pago_id = $this->metodo_id_3;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                if($this->metodo_id_3 == 3){
                    $this->caja_detalle->update([
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto3) - $efectivo_bs_decrec,
                    ]);
                }

                if($this->metodo_id_3 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto3) - $efectivo_dls_decrec,
                    ]);
                }
            }
            elseif($this->cant_metodos == 4) {
                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto1;
                $pago_venta->metodo_pago_id = $this->metodo_id_1;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto2;
                $pago_venta->metodo_pago_id = $this->metodo_id_2;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto3;
                $pago_venta->metodo_pago_id = $this->metodo_id_3;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto4;
                $pago_venta->metodo_pago_id = $this->metodo_id_4;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                if($this->metodo_id_4 == 3){
                    $this->caja_detalle->update([
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto4) - $efectivo_bs_decrec,
                    ]);
                }

                if($this->metodo_id_4 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto4) - $efectivo_dls_decrec,
                    ]);
                }
            }
            else{
                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto1;
                $pago_venta->metodo_pago_id = $this->metodo_id_1;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto2;
                $pago_venta->metodo_pago_id = $this->metodo_id_2;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto3;
                $pago_venta->metodo_pago_id = $this->metodo_id_3;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto4;
                $pago_venta->metodo_pago_id = $this->metodo_id_4;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                $pago_venta = new Pago_venta();
                $pago_venta->monto = $this->monto5;
                $pago_venta->metodo_pago_id = $this->metodo_id_5;
                $pago_venta->venta_id = $venta->id;
                $pago_venta->save();

                if($this->metodo_id_5 == 3){
                    $this->caja_detalle->update([
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto5) - $efectivo_bs_decrec,
                    ]);
                }

                if($this->metodo_id_5 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto5) - $efectivo_dls_decrec,
                    ]);
                }
            }

            //REGISTRO DE VENTA EN CAJA
            $movimiento = new MovimientoCaja();
            $movimiento->fecha = date('Y-m-d');
            $movimiento->tipo_movimiento = 1;
            if ($this->tipo_pago == "2") $movimiento->cantidad = $this->pago_cliente;
            else $movimiento->cantidad = $this->total_venta;
            if ($this->tipo_pago == "2") $movimiento->observacion = 'Venta a credito';
            else  $movimiento->observacion = 'Venta a contado';
            $movimiento->user_id = $user_auth;
            $movimiento->sucursal_id = $this->sucursal;
            $movimiento->caja_id = $this->caja;
            $movimiento->estado = 'entregado';
            $movimiento->save();

            if ($this->tipo_pago == "2") $total_recibido = $this->pago_cliente;
            else $total_recibido = $this->total_venta;
             
            $sucursales1 = Sucursal::all();

            foreach (Cart::content() as $item) {
                //GUARDANDO PRODUCTOS VENDIDOS EN ID VENTA
                $venta->producto_ventas()->create([
                    'venta_id' => $venta->id,
                    'producto_id'=> $item->id,
                    'precio' => $item->price,
                    'cantidad' => $item->qty,
                ]);

                $producto_barra = Producto::where('id',$item->id)->first();
            
                //GUARDANDO MOVIMIENTO KARDEX
                $producto_barra->movimientos()->create([
                    'fecha' => date('Y-m-d'),
                    'cantidad_entrada' => 0,
                    'cantidad_salida' => $item->qty,
                    'stock_antiguo' => $producto_barra->cantidad,
                    'stock_nuevo' => $producto_barra->cantidad - $item->qty,
                    'precio_entrada' => 0,
                    'precio_salida' => $item->price,
                    'detalle' => 'Venta de producto - Venta Nro ' .$venta->id,
                    'user_id' => $user_auth
                ]);

                //ACTUALIZANDO CANTIDAD DE PRODUCTOS DISPONIBLES EN INVENTARIO
                $producto_barra->update([
                    'cantidad' => $producto_barra->cantidad - $item->qty,
                ]);

                //DESCUENTO CANTIDAD EN TABLA PRODUCTO SUCURSAL
                discount($item->id,$this->sucursal,$item->qty,$item->options['lote']);
            }

        }

        //GENERANDO COMPROBANTE
        if($this->proforma == 'proforma') $venta_nro_p = '1';
        else $venta_nro_p = $venta->id;
    
        $data = [
            'cliente_nombre' => $this->client->nombre." ".$this->client->apellido,
            'cliente_documento' =>$this->client->nro_documento,
            'cliente_telefono' =>$this->client->telefono,
            'usuario' => auth()->user()->name." ".auth()->user()->apellido,
            'fecha_actual' => date('Y-m-d'),
            'venta_nro' => $venta_nro_p,
            'sucursal' => $this->sucursal_detalle->nombre,
            'caja' => $this->caja_detalle->nombre,
            'empresa' => $this->empresa,
            'collection' => Cart::content(),
            'estado_entrega' => $entrega,
            'descuento' => $this->descuento_total,
            'subtotal' =>  $this->subtotal,
            'subtotal_menos_descuento' =>  $this->subtotal - ($this->descuento_total),
            'total' => $this->total_venta,
            'proforma' =>$this->proforma,
            'iva_empresa' => $this->iva_empresa,
            'pagado' => $this->pago_cliente,
            'deuda' => $this->total_venta - $this->pago_cliente,
            'iva' => $this->iva,];

        //factura
        if($this->tipo_comprobante == "1"){ 
            if ($this->tipo_pago == "Contado") $pdf = PDF::loadView('ventas.FacturaContado',$data)->output();
            else $pdf = PDF::loadView('ventas.FacturaCredito',$data)->output();

            if($this->send_mail=="1"){
                if( $this->client->email != null){
                    $data_m["email"] = $this->client->email;
                    $data_m["title"] = "Comprobante de pago";
                    $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
                    Mail::send('ventas.FacturaContado', $data, function ($message) use ($data_m, $pdf) {
                    $message->to($data_m["email"], $data_m["email"])
                        ->subject($data_m["title"])
                        ->attachData($pdf, "Comprobante.pdf");
                    });
                }
            }
        }
        //ticket 
        elseif($this->tipo_comprobante == "2"){ 
            $nombreImpresora = "POS-58";
            $connector = new WindowsPrintConnector($nombreImpresora);
            $impresora = new Printer($connector);
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setTextSize(2, 2);
            $impresora->text($this->empresa->nombre ."\n");
            $impresora->text("\n");
            $impresora->setTextSize(1, 1);
            $impresora->text($this->empresa->nro_documento ."\n");
            $impresora->text($this->empresa->direccion ."\n");
            $impresora->text("Tlf.".$this->empresa->telefono ."\n");
            $impresora->text("Email: ".$this->empresa->email ."\n");
            $impresora->text("--------------------------------\n");
            $impresora->text("Factura Nro. ".$venta_nro_p ."\n");
            $impresora->text("Fecha: ".date('d-m-Y') ."\n");
            $impresora->text("Cajero: ".auth()->user()->name." ".auth()->user()->apellido ."\n");
            $impresora->text("Caja: ".$this->caja_detalle->nombre ."\n");
            $impresora->text("--------------------------------\n");
            $impresora->text("Cliente: ".$this->client->nombre." ".$this->client->apellido ."\n");
            $impresora->text("Documento Nro.: ".$this->client->nro_documento ."\n");
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text("________________________________\n");
            $impresora->text(" Cant.   Descripción   Subtotal\n");
            $impresora->text("--------------------------------\n");
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            foreach (Cart::content() as $item) {
                if($item->options['exento'] == "Si") $impresora->text(str_pad($item->qty,7).str_pad(substr($item->name,0,12), 10)."(E) ".str_pad($item->price,10)."\n"); 
                else $impresora->text(str_pad($item->qty,7).str_pad(substr($item->name,0,12), 14)." ".str_pad($item->price,10)."\n");
            } 
            $impresora->text("\n");
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->text('SUBTOTAL: Bs ' . $this->subtotal - ($this->descuento_total) . "\n");
            $impresora->text('DESCUENTO: Bs ' . $this->descuento_total . "\n");
            $impresora->text('IVA('. $this->iva_empresa. '%): Bs '. $this->iva . "\n");
            $impresora->text('TOTAL: Bs ' .$this->total_venta. "\n");
            if ($this->tipo_pago == "Credito"){
                $impresora->text('PAGADO: Bs ' .$this->pago_cliente. "\n");
                $impresora->text('PENDIENTE: Bs ' .$this->total_venta - $this->pago_cliente. "\n");  
            }
            $impresora->text("\n");
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("¡GRACIAS POR SU COMPRA!\n");
            $impresora->feed(3);
            $impresora->close();
        }
        //nota de entrega
        else{ 
            if ($this->tipo_pago == "Contado") $pdf = PDF::loadView('ventas.NotaEntregaContado',$data)->output();
            else  $pdf = PDF::loadView('ventas.NotaEntregaCredito',$data)->output();
                    
            if($this->send_mail=="1"){
                if( $this->client->email != null){
                    $data_m["email"] = $this->client->email;
                    $data_m["title"] = "Comprobante de pago";
                    $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
                    Mail::send('ventas.NotaEntregaContado', $data, function ($message) use ($data_m, $pdf) {
                        $message->to($data_m["email"], $data_m["email"])
                            ->subject($data_m["title"])
                            ->attachData($pdf, "Comprobante.pdf");
                    });
                }
            }
        }
        cart::destroy();

        $this->client = Cliente::where('id','1')->first();
        $this->cliente_select = $this->client->nombre." ".$this->client->apellido;

        $this->reset(['monto1','monto2','monto3','monto4','monto5','metodo_id_1','metodo_id_2','metodo_id_3','metodo_id_4','metodo_id_5','send_mail','cash_received','total_venta','pago_cliente','descuento','descuento_total','metodo_pago','tipo_pago','estado_entrega','subtotal']);
       
        if($this->imprimir == 1){
            $this->reset(['imprimir']);
            $this->emitTo('ventas.ventas-seleccion-productos','render');
            $this->emitTo('ventas.ventas-cart','render');
    
            //GENERANDO PDF
           if($this->tipo_comprobante == 1 || $this->tipo_comprobante == 3){
                return response()->streamDownload(
                    fn () => print($pdf),
                "Comprobante.pdf"
                );
            }
         }
         else {
            $this->emitTo('ventas.ventas-seleccion-productos','render');
            $this->emitTo('ventas.ventas-cart','render');
        }
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Eliminar un producto de la venta: Haga click en el botón " <i class="fas fa-trash"></i> ", ubicado al lado del producto que desea eliminar.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Eliminar todos los productos de la venta: Haga click en el botón " <i class="fas fa-trash"></i> Borrar todos los productos ", ubicado en el área inferior izquierda del listado de productos.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Continuar con la venta: Haga click sobre el botón "Continuar>>" ubicado en la zona inferior izquierda </p>');
    }
    
}
