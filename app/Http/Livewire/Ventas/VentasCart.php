<?php

namespace App\Http\Livewire\Ventas;

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
use Illuminate\Support\Facades\Mail;

class VentasCart extends Component
{
    use WithPagination;

    public $sucursal,$producto,$cambio;
    public $cash_received,$tipo_pago = "Contado",$tipo_comprobante,$send_mail,$imprimir,$ticket = 0, $impresoras, $impresora_id ="";
    public $metodo_pago, $total, $client, $search;
    public $cliente_select, $total_venta, $pago_cliente, $deuda_cliente, $descuento, $estado_entrega = "Entregado",$subtotal,$proforma;
    public $siguiente_venta = 0;
    public $iva, $carrito,$valor, $iva_empresa;
    public $puntos_canjeo, $canjeo, $puntos_canjeados, $descuento_total,$porcentaje_descuento_puntos = 0,$empresa, $other_method;

    protected $listeners = ['render'];
    protected $paginationTheme = "bootstrap";

    public $rules = [
        'tipo_pago' => 'required',
        'metodo_pago' => 'required',
        'estado_entrega' => 'required',
        'cliente_select' => 'required',
    ];
    public $rule_credito = [
        'tipo_pago' => 'required',
        'metodo_pago' => 'required',
        'estado_entrega' => 'required',
        'pago_cliente' => 'required',
        'cliente_select' => 'required',
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
        $this->cliente_select = "";
        //$this->puntos_canjeo = 0;
        //$this->canjeo = false;
        //$this->puntos_canjeados = 0;
        $this->empresa = Empresa::first();
        $this->iva_empresa = $this->empresa->impuesto;
    }

    public function select_u($cliente_id){
        $this->client = Cliente::where('id',$cliente_id)->first();
        $this->cliente_select = $this->client->nombre." ".$this->client->apellido;
        //$this->puntos_canjeo = $this->client->puntos;
    }

    public function render()
    {
        $caracter=",";
        $this->subtotal = str_replace($caracter,"",Cart::subtotal());

          
       // if($this->canjeo==false){
            if($this->descuento != null){
                $this->iva= ($this->empresa->impuesto / 100) * $this->subtotal;
                
                $this->descuento_total = $this->subtotal  * $this->descuento / 100;
                $this->total_venta = ($this->subtotal  - $this->descuento_total) + $this->iva;
            }
            else{
                $this->iva= ($this->empresa->impuesto / 100) * $this->subtotal;
                $this->total_venta = $this->subtotal +  $this->iva;
                $this->descuento_total = 0;
            } 
        /*}else{
            $this->porcentaje_descuento_puntos = $this->empresa->porcentaje_puntos;
            if($this->descuento != null){
            $this->descuento_total = $this->subtotal  * (($this->descuento / 100) + ($this->porcentaje_descuento_puntos / 100));
            $this->total_venta = ($this->subtotal ) - $this->descuento_total;
            }
            $this->descuento_total = $this->subtotal  * ($this->porcentaje_descuento_puntos / 100); 
            $this->total_venta = ($this->subtotal ) - $this->descuento_total;
        } */

        //if($this->cash_received != null && $this->other_method == null) $this->cambio = abs($this->cash_received - $this->total_venta);
        if($this->cash_received != null && $this->other_method == null) $this->cambio = $this->cash_received - $this->total_venta;
        elseif($this->cash_received != null && $this->other_method != null) $this->cambio = (($this->cash_received + $this->other_method) - $this->total_venta);
        else $this->cambio = 0;

        $clientes = Cliente::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->orwhere('apellido', 'LIKE', '%' . $this->search . '%')
        ->orwhere('nro_documento', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(2);

        return view('livewire.ventas.ventas-cart',compact('clientes'));
    }

   /* public function canjear($producto_id){
        $this->puntos_canjeo = "1";
        $this->canjeo = true;
        $this->porcentaje_descuento_puntos = $this->empresa->porcentaje_puntos;
        $product_canje = Producto::where('id',$producto_id)->first();
        $this->puntos_canjeados = $product_canje->puntos;
    }*/

    public function save(){
    /*    if ($this->tipo_pago == "1"){
            $rules = $this->rules;
            $this->validate($rules);
        }
        else{
            $rule_credito = $this->rule_credito;
            $this->validate($rule_credito);   
        }*/
 
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
            $caja_final= Sucursal::where('id',$this->sucursal)->first();
            $saldo_caja_final = $caja_final->saldo;

             //PROCESO DE SUMAR O RESTAR PUNTOS EN TABLA DE CLIENTES
           /* if($this->canjeo==false){
                $nuevos_puntos = $this->client->puntos + round($this->total_venta,0);
                //Agregando nuevos puntos al cliente
                $this->client->update([
                    'puntos' => round($nuevos_puntos),
                ]);
            }
            else{
                //descontando puntos y agregando los nuevos
                $nuevos_puntos = ($this->client->puntos - $this->puntos_canjeados) + round($this->total_venta,0);

                $this->client->update([
                    'puntos' => round($nuevos_puntos),
                ]);
            }   */


            //REGISTRANDO VENTA EN TABLA DE VENTAS
            $venta = new Venta();
            $venta->user_id = $user_auth;
            $venta->cliente_id = $this->client->id;
            $venta->fecha = date('Y-m-d');
            $venta->tipo_pago = $this->tipo_pago;
            $venta->metodo_pago = $this->metodo_pago;
            if ($this->tipo_pago == "Credito"){
                $venta->total_pagado_cliente = $this->pago_cliente;
                $venta->deuda_cliente = $this->total_venta - $this->pago_cliente;
            }
            else{
                $venta->total_pagado_cliente = $this->total_venta;
                $venta->deuda_cliente = "0";
            }
            $venta->subtotal =  $this->subtotal;
            $venta->total = $this->total_venta;
            $venta->sucursal_id = $this->sucursal;
            $venta->estado_entrega = $this->estado_entrega;
            $venta->descuento = $this->descuento_total;
            $venta->impuesto=$this->iva;
            $venta->estado='activa';
            $venta->save();

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
            $movimiento->estado = 'entregado';
            $movimiento->save();

            if ($this->tipo_pago == "2") $total_recibido = $this->pago_cliente;
            else $total_recibido = $this->total_venta;

           
            //REGISTRANDO VENTA EN TABLAS DE SUCURSAL AÑADIENDO SALDO
            $caja_final->update([
                'saldo' => $saldo_caja_final + $total_recibido,
            ]);  
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
                discount($item->id,$this->sucursal,$item->qty);
            }

        }

        //GENERANDO FACTURAS

        if($this->proforma == 'proforma') $venta_nro_p = '1';
        else $venta_nro_p = $venta->id;
    
            if ($this->tipo_pago == "Contado"){
                $data = [
                    'cliente_nombre' => $this->client->nombre." ".$this->client->apellido,
                    'cliente_documento' =>$this->client->nro_documento,
                    'cliente_telefono' =>$this->client->telefono,
                    'usuario' => auth()->user()->name." ".auth()->user()->apellido,
                    'fecha_actual' => date('Y-m-d'),
                    'venta_nro' => $venta_nro_p,
                    'empresa' => $this->empresa,
                    'collection' => Cart::content(),
                    'estado_entrega' => $entrega,
                    'descuento' => $this->descuento_total,
                    'subtotal' =>  $this->subtotal,
                    'subtotal_menos_descuento' =>  $this->subtotal - ($this->descuento_total),
                    'total' => $this->total_venta,
                    'proforma' =>$this->proforma,
                    'iva_empresa' => $this->iva_empresa,
                    'iva' => $this->iva,];

                if($this->tipo_comprobante == "1"){ 
                    $pdf = PDF::loadView('ventas.FacturaContado',$data)->output();

                    if($this->send_mail=="1"){
                        if( $this->client->email != null){
                            $data_m["email"] = $this->client->email;
                            $data_m["title"] = "Comprobante de pago - Tech";
                            $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
                            Mail::send('ventas.FacturaContado', $data, function ($message) use ($data_m, $pdf) {
                            $message->to($data_m["email"], $data_m["email"])
                                ->subject($data_m["title"])
                                ->attachData($pdf, "Comprobante.pdf");
                            });
                        }
                    }
                }
                else{ 
                    $pdf = PDF::loadView('ventas.TicketContado',$data)->output();

                    if($this->send_mail=="1"){
                        if( $this->client->email != null){
                            $data_m["email"] = $this->client->email;
                            $data_m["title"] = "Comprobante de pago - Tech";
                            $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
                            Mail::send('ventas.TicketContado', $data, function ($message) use ($data_m, $pdf) {
                                $message->to($data_m["email"], $data_m["email"])
                                    ->subject($data_m["title"])
                                    ->attachData($pdf, "Comprobante.pdf");
                            });
                        }
                    }
                }
            }
            else{
                $data = [
                    'cliente_nombre' => $this->client->nombre." ".$this->client->apellido,
                    'cliente_documento' =>$this->client->nro_documento,
                    'cliente_telefono' =>$this->client->telefono,
                    'usuario' => auth()->user()->name." ".auth()->user()->apellido,
                    'fecha_actual' => date('Y-m-d'),
                    'venta_nro' => $venta_nro_p,
                    'collection' => Cart::content(),
                    'empresa' => $this->empresa,
                    'estado_entrega' => $entrega,
                    'descuento' => $this->descuento_total,
                    'proforma' => $this->proforma,
                    'pagado' => $this->pago_cliente,
                    'deuda' => $this->total_venta - $this->pago_cliente,
                    'subtotal' =>  $this->subtotal,
                    'total' => $this->total_venta,
                    'iva' => $this->iva,
                    'iva_empresa' => $this->iva_empresa,
                ];
                if($this->tipo_comprobante == "1"){
                    $pdf = PDF::loadView('ventas.FacturaCredito',$data)->output();

                    if($this->send_mail=="1"){
                        if( $this->client->email != null){
                            $data_m["email"] = $this->client->email;
                            $data_m["title"] = "Comprobante de pago - Tech";
                            $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
                            Mail::send('ventas.FacturaCredito', $data, function ($message) use ($data_m, $pdf) {
                                $message->to($data_m["email"], $data_m["email"])
                                    ->subject($data_m["title"])
                                    ->attachData($pdf, "Comprobante.pdf");
                            });
                        }
                    }
                }
                else
                {

                    $pdf = PDF::loadView('ventas.TicketCredito',$data)->output();
                    if($this->send_mail=="1"){
                        if( $this->client->email != null){
                            $data_m["email"] = $this->client->email;
                            $data_m["title"] = "Comprobante de pago - Tech";
                            $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";         
                            Mail::send('ventas.TicketCredito', $data, function ($message) use ($data_m, $pdf) {
                                $message->to($data_m["email"], $data_m["email"])
                                    ->subject($data_m["title"])
                                    ->attachData($pdf, "Comprobante.pdf");
                            });
                        }
                    }
                }
            }

        cart::destroy();
        $this->siguiente_venta = '1';
        $this->reset(['cliente_select','send_mail','cash_received','total_venta','pago_cliente','descuento','descuento_total','tipo_comprobante','metodo_pago','tipo_pago','estado_entrega','subtotal']);
       
         
         if($this->imprimir == 1){
            $this->reset(['imprimir']);
            $this->emitTo('ventas.ventas-seleccion-productos','render');
    
        //GENERANDO PDF
           return response()->streamDownload(
                fn () => print($pdf),
               "Comprobante.pdf"
                );
         }
         else {
            $this->emitTo('ventas.ventas-seleccion-productos','render');
        }
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Eliminar un producto de la venta: Haga click en el botón " <i class="fas fa-trash"></i> ", ubicado al lado del producto que desea eliminar.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Eliminar todos los productos de la venta: Haga click en el botón " <i class="fas fa-trash"></i> Borrar todos los productos ", ubicado en el área inferior izquierda del listado de productos.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Continuar con la venta: Haga click sobre el botón "Continuar>>" ubicado en la zona inferior izquierda </p>');
    }
    
}
