<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\impresora;
use App\Models\Movimiento;
use App\Models\Movimiento_product_serial;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\ProductoSerialSucursal;
use App\Models\Proforma;
use App\Models\Sucursal;
use App\Models\Venta;
use Facade\FlareClient\Http\Client;
use Gloudemans\Shoppingcart\Facades\Cart;
Use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade;
use Barryvdh\DomPDF\ServiceProvider;
use PDF;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class VentaFacturacion extends Component
{

    use WithPagination;
    public $tipo_pago,$tipo_comprobante,$send_mail,$imprimir,$ticket = 0, $impresoras, $impresora_id ="";
    public $metodo_pago, $total, $client, $search;
    public $sucursal,$cliente_select, $pago_cliente, $deuda_cliente, $descuento, $estado_entrega,$subtotal,$proforma;
    public $siguiente_venta = 0;
    public $iva, $carrito;
    public $puntos_canjeo, $canjeo, $puntos_canjeados, $descuento_total,$porcentaje_descuento_puntos = 0,$empresa;
 
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render'];
    
    public $rules = [
        'tipo_pago' => 'required',
        'metodo_pago' => 'required',
        'estado_entrega' => 'required',
        'descuento' => 'required',
        'cliente_select' => 'required',
    ];
    public $rule_credito = [
        'tipo_pago' => 'required',
        'metodo_pago' => 'required',
        'estado_entrega' => 'required',
        'descuento' => 'required',
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

    public function render()
    {
        $this->carrito = Cart::content();
        $this->empresa = Empresa::first();
        $this->iva = ($this->empresa->impuesto)/100;

        if($this->descuento != null)  $this->descuento = $this->descuento;
        else $this->decuento = (int) $this->descuento;       
        

        $clientes = Cliente::where('nombre', 'LIKE', '%' . $this->search . '%')
        ->orwhere('apellido', 'LIKE', '%' . $this->search . '%')
        ->orwhere('nro_documento', 'LIKE', '%' . $this->search . '%')
        ->latest('id')
        ->paginate(2);

        return view('livewire.ventas.venta-facturacion',compact('clientes'));
    }

    public function mount()
    {
        $this->cliente_select = "";
        $this->puntos_canjeo = "0";
        $this->canjeo = false;
        $this->puntos_canjeados = 0;
        //$this->descuento_total = 0;

    }

    public function select_u($cliente_id){
        $this->client = Cliente::where('id',$cliente_id)->first();
        $this->cliente_select = $this->client->nombre." ".$this->client->apellido;
        $this->puntos_canjeo = $this->client->puntos;
      
       // $this->puntos_canjeo = "0";
    }

    public function save(){

        
        if ($this->tipo_pago == "1"){
            $rules = $this->rules;
            $this->validate($rules);
        }
        else{
            $rule_credito = $this->rule_credito;
            $this->validate($rule_credito);   
        }
 
        $user_auth =  auth()->user()->id;
       // $impuesto= Cart::subtotal() * $this->iva;

        //PROFORMA
        if($this->proforma == 'proforma'){
            if($this->canjeo==false){
                $descuento_total = Cart::subtotal() * ($this->descuento / 100);
                $total_venta = (Cart::subtotal()) - $descuento_total;
            }else{
                $descuento_total = Cart::subtotal() * (($this->descuento / 100) + ($this->porcentaje_descuento_puntos / 100));
                $total_venta = (Cart::subtotal()) - $descuento_total;
            } 
            
            if($this->estado_entrega == "1") $entrega = 'Entregado'; else
            $entrega = 'Por entregar';
            
            $proform = new Proforma();
            $proform->user_id = $user_auth;
            $proform->cliente_id = $this->client->id;
            $proform->fecha = date('Y-m-d');
            $proform->tipo_pago = $this->tipo_pago;
            $proform->metodo_pago = $this->metodo_pago;
            if ($this->tipo_pago == "2"){
                $proform->total_pagado_cliente = $this->pago_cliente;
                $proform->deuda_cliente = $total_venta - $this->pago_cliente;
            }
            else{
                $proform->total_pagado_cliente = $total_venta;
                $proform->deuda_cliente = "0";
            }
            $proform->subtotal = Cart::subtotal();
            $proform->total = $total_venta;
            $proform->sucursal_id = $this->sucursal;
            $proform->estado_entrega = $entrega;
            $proform->descuento = $descuento_total;
           // $proform->impuesto=$impuesto;
            $proform->estado='activa';
            $proform->save();

            foreach (Cart::content() as $item) {
                //generando producto_por_serial_venta
                $proform->producto_proformas()->create([
                    'proforma_id' => $proform->id,
                    'producto_serial_sucursal_id'=> $item->id,
                    'precio' => $item->price,
                    'cantidad' => 1,
                ]);
            }

        }
        //VENTA
        else
        {
            $caja_final= Sucursal::where('id',$this->sucursal)->first();
            $saldo_caja_final = $caja_final->saldo;

             //PROCESO DE SUMAR O RESTAR PUNTOS EN TABLA DE CLIENTES

            if($this->canjeo==false){
                $descuento_total = Cart::subtotal() * ($this->descuento / 100);
                $total_venta = (Cart::subtotal()) - $descuento_total;
                $nuevos_puntos = $this->client->puntos + round($total_venta,0);

                $this->client->update([
                    'puntos' => round($nuevos_puntos),
                ]);
            }
            else{
                $descuento_total = Cart::subtotal() * (($this->descuento / 100) + ($this->porcentaje_descuento_puntos / 100));
                $total_venta = (Cart::subtotal()) - $descuento_total;
                //verifica si es porque debes colocar entero el total velo con dd a ver que te trae
                
                $nuevos_puntos = ($this->client->puntos - $this->puntos_canjeados) + round($total_venta,0);

                $this->client->update([
                    'puntos' => round($nuevos_puntos),
                ]);
            }   

      


            if($this->estado_entrega == "1") $entrega = 'Entregado'; else
            $entrega = 'Por entregar';

            //REGISTRANDO VENTA EN TABLA DE VENTAS
            $venta = new Venta();
            $venta->user_id = $user_auth;
            $venta->cliente_id = $this->client->id;
            $venta->fecha = date('Y-m-d');
            $venta->tipo_pago = $this->tipo_pago;
            $venta->metodo_pago = $this->metodo_pago;
            if ($this->tipo_pago == "2"){
                $venta->total_pagado_cliente = $this->pago_cliente;
                $venta->deuda_cliente = $total_venta - $this->pago_cliente;
                 //REGISTRANDO MOVIMIENTO EN CAJA DE ENTA A CREDITO
                $movimiento = new MovimientoCaja();
                $movimiento->fecha = date('Y-m-d');
                $movimiento->tipo_movimiento = 1;
                $movimiento->cantidad = $this->pago_cliente;
                $movimiento->observacion = 'Venta a credito';
                $movimiento->user_id = $user_auth;
                $movimiento->sucursal_id = $this->sucursal;
                $movimiento->estado = 'entregado';
                $movimiento->save();

                $total_recibido = $this->pago_cliente;
            }
            else{
                $venta->total_pagado_cliente = $total_venta;
                $venta->deuda_cliente = "0";
                //REGISTRANDO MOVIMIENTO EN CAJA DE ENTA A CONTADO
                $movimiento = new MovimientoCaja();
                $movimiento->fecha = date('Y-m-d');
                $movimiento->tipo_movimiento = 1;
                $movimiento->cantidad = $total_venta;
                $movimiento->observacion = 'Venta a contado';
                $movimiento->user_id = $user_auth;
                $movimiento->sucursal_id = $this->sucursal;
                $movimiento->estado = 'entregado';
                $movimiento->save();

                $total_recibido = $total_venta;
            }
            $venta->subtotal = Cart::subtotal();
            $venta->total = $total_venta;
            $venta->sucursal_id = $this->sucursal;
            $venta->estado_entrega = $entrega;
            $venta->descuento = $descuento_total;
            //$venta->impuesto=$impuesto;
            $venta->estado='activa';
            $venta->save();

            //REGISTRANDO VENTA EN TABLAS DE SUCURSAL AÑADIENDO SALDO
            $caja_final->update([
                'saldo' => $saldo_caja_final + $total_recibido,
            ]);  
            $sucursales1 = Sucursal::all();
            foreach (Cart::content() as $item) {
                //generando producto_por_serial_venta
                $venta->producto_ventas()->create([
                    'venta_id' => $venta->id,
                    'producto_serial_sucursal_id'=> $item->id,
                    'precio' => $item->price,
                    'cantidad' => 1,
                ]);
                
                $producto_item = ProductoSerialSucursal::where('id',$item->id)->first();
                $producto_item->update([
                    'estado' => 'inactivo por venta',
                ]);

                $producto_barra = Producto::where('id',$producto_item->producto->id)->first();

                //Guardando movimiento de producto para kardex

                $stock_antiguo = 0;
                foreach($sucursales1 as $sucursalx){
                    $stock_antiguo = $producto_barra->sucursals->find($sucursalx)->pivot->cantidad + $stock_antiguo;
                }

                $stock_nuevo = $stock_antiguo -1;
                $producto_barra->movimientos()->create([
                    'fecha' => date('Y-m-d'),
                    'cantidad_entrada' => 0,
                    'cantidad_salida' => 1,
                    'stock_antiguo' => $stock_antiguo,
                    'stock_nuevo' => $stock_nuevo,
                    'precio_entrada' => 0,
                    'precio_salida' => $item->price,
                    'detalle' => 'Venta de producto - Venta Nro ' .$venta->id .' Serial de producto:'. $producto_item->serial ,
                    'user_id' => $user_auth
                ]);


                //descuento la cantidad en tabla producto_sucursal
                discount($producto_item->producto->id,$this->sucursal);
            }

        }

        if($this->proforma == 'proforma') $venta_nro_p = '1';
        else $venta_nro_p = $venta->id;

    
            if ($this->tipo_pago == "1"){
                $data = [
                    'cliente_nombre' => $this->client->nombre." ".$this->client->apellido,
                    'cliente_documento' =>$this->client->nro_documento,
                    'cliente_telefono' =>$this->client->telefono,
                    'usuario' => auth()->user()->name." ".auth()->user()->apellido,
                    'fecha_actual' => date('Y-m-d'),
                    'venta_nro' => $venta_nro_p,
                    'collection' => Cart::content(),
                    'estado_entrega' => $entrega,
                    'descuento' => $descuento_total,
                    'subtotal' => Cart::subtotal(),
                    'subtotal_menos_descuento' => Cart::subtotal() - ($descuento_total),
                    'total' => $total_venta,
                    'proforma' =>$this->proforma,
                    'iva' => $this->iva,];

                if($this->tipo_comprobante == "1"){ 
                    $pdf = PDF::loadView('ventas.FacturaContado',$data)->output();

                    if($this->send_mail=="1"){
                        $data_m["email"] = $this->client->email;
                        $data_m["title"] = "Comprobante de pago - Tech";
                        $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
            
                       // $pdf_m = PDF::loadView('mail', $data_m);
            
                        Mail::send('ventas.FacturaContado', $data, function ($message) use ($data_m, $pdf) {
                            $message->to($data_m["email"], $data_m["email"])
                                ->subject($data_m["title"])
                                ->attachData($pdf, "Comprobante.pdf");
                        });
            
                    }
                }
                else{ 
                    $pdf = PDF::loadView('ventas.TicketContado',$data)->output();

                    if($this->send_mail=="1"){
                        $data_m["email"] = $this->client->email;
                        $data_m["title"] = "Comprobante de pago - Tech";
                        $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
            
                       // $pdf_m = PDF::loadView('mail', $data_m);
            
                        Mail::send('ventas.TicketContado', $data, function ($message) use ($data_m, $pdf) {
                            $message->to($data_m["email"], $data_m["email"])
                                ->subject($data_m["title"])
                                ->attachData($pdf, "Comprobante.pdf");
                        });
            
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
                    'estado_entrega' => $entrega,
                    'descuento' => $descuento_total,
                    'proforma' => $this->proforma,
                    'pagado' => $this->pago_cliente,
                    'deuda' => $total_venta - $this->pago_cliente,
                    'subtotal' => Cart::subtotal(),
                    'total' => $total_venta,
                    'iva' => $this->iva,

                ];
                if($this->tipo_comprobante == "1"){
                    $pdf = PDF::loadView('ventas.FacturaCredito',$data)->output();

                    if($this->send_mail=="1"){
                        $data_m["email"] = $this->client->email;
                        $data_m["title"] = "Comprobante de pago - Tech";
                        $data_m["body"] = "Anexo se encuentra el comprobante de pago de su compra realizada hoy.";
            
                       // $pdf_m = PDF::loadView('mail', $data_m);
            
                        Mail::send('ventas.FacturaCredito', $data, function ($message) use ($data_m, $pdf) {
                            $message->to($data_m["email"], $data_m["email"])
                                ->subject($data_m["title"])
                                ->attachData($pdf, "Comprobante.pdf");
                        });
            
                    }
                }
                else
                {

                    $pdf = PDF::loadView('ventas.TicketCredito',$data)->output();
                    if($this->send_mail=="1"){
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

        cart::destroy();
        $this->siguiente_venta = '1';
        $this->reset(['cliente_select','pago_cliente','descuento','descuento_total','tipo_comprobante','send_mail']);

         //GENERANDO PDF
         if($this->imprimir == 1){
            $this->reset(['imprimir']);
            return response()->streamDownload(
                fn () => print($pdf),
               "Comprobante.pdf"
                );
         }
         //Regresando a la ventana de inicio
         else {
            if($this->proforma == 'proforma'){
                $this->emit('alert','Proforma Registrada');
                return redirect()->route('proformas.proformas.index');
            }
            else{
                $this->emit('alert','Venta registrada');
                return redirect()->route('ventas.ventas.index');
            }
        }
    }

    public function canjear($producto_id){
        $this->puntos_canjeo = "1";
        $this->canjeo = true;
        $this->porcentaje_descuento_puntos = $this->empresa->porcentaje_puntos;
        $product_canje = ProductoSerialSucursal::where('id',$producto_id)->first();
        $this->puntos_canjeados = $product_canje->producto->puntos;
        $this->descuento_total = Cart::subtotal() * (($this->descuento / 100) + ($this->porcentaje_descuento_puntos / 100));  
    }

    public function nueva_venta(){
     return redirect()->route('ventas.ventas.index');
    }

    public function inicio(){
        return redirect()->route('home');
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Seleccionar cliente ya registrado: Haga click en el botón " <i class="fas fa-check"></i>", ubicado al lado de cada cliente.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Registrar cliente para la venta si no esta registrado: Haga click en el botón " <i class="fas fa-user-plus"></i> Nuevo cliente" ubicado al lado de la Guía rápida.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Canjeo de puntos: Si el cliente tiene suficientes puntos para canjear en algún producto, al lado del o los productos le aparecerá el botón "<i class="fas fa-award p-0"></i>", solo debe hacer click sobre él para añadir el descuento a la cuenta total parcial de la venta --MUY IMPORTANTE SI VA A HACER UN DESCUENTO ADICIONAL A LA VENTA DEBE COLOCAR PRIMERO ESE DESCUENTO Y LUEGO CANJEAR LOS PUNTOS-- </p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3. Campos obligatorios: Método de pago, tipo de pago, estado de entrega y descuento en venta, si el tipo de pago es al contado debe ingresar como campo obligatorio el total pagado por el cliente.</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">4-. Enviar comprobante al correo del cliente: si desea que el sistema envie una copia del comprobante de pago debe seleccionar el check ubicado al lado de "Enviar comprobante al correo del cliente". </p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">5-. Guardar venta: para culminar con la venta haga click en "Guardar venta ubicado en la zona inferior izquierda"</p>
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">6-. Si desea imprimir comprobante, debe hacer click sobre el check ubicado al lado de "Imprimir comprobante", seguidamente como campo obligatorio debe seleccionar el tipo de comprobante, al guardar la venta el comprobante se descargara automáticamente solo debe abrirlo e imprimirlo. </p>');
    }

}
