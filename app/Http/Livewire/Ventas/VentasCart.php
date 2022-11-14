<?php
//require_once "vendor/autoload.php";

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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use GuzzleHttpClient;

class VentasCart extends Component
{
    use WithPagination;

    public $ocultar_panel,$publico_general = 1, $sucursal,$caja, $caja_detalle, $sucursal_detalle,$producto,$cambio,$moneda_actual,$tasa_dia,$moneda_nombre,$moneda_simbolo;
    public $cash_received,$tipo_pago = "contado",$tipo_comprobante,$send_mail,$imprimir,$ticket = 0;
    public $metodo_pago, $total, $client, $search;
    public $cliente_select, $total_venta, $pago_cliente, $deuda_cliente, $descuento, $estado_entrega = "Entregado",$subtotal,$proforma;
    public $siguiente_venta = 0, $monto1, $monto2, $monto3, $monto4, $monto5,$metodo_id_1,$metodo_id_2,$metodo_id_3,$metodo_id_4,$metodo_id_5,$vuelto="no", $monto_vuelto, $metodo_cambio_id;
    public $iva, $carrito,$valor, $iva_empresa,$cant_metodos = 1,$metodos;
    public $subt_e, $descuento_total = 0,$empresa, $other_method,$mostrar_total_pagado_bs=0,$mostrar_total_pagado_dl=0,$mostrar_total_cambio_bs=0,$mostrar_total_cambio_dl=0,$por_cancelar,$tasa_metodo,$pendiente_pagar_cliente_bs=0,$pendiente_pagar_cliente_dl=0;

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

  /*  public $rules_cant_pago_4 = [
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
    ];*/

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

  /*  public function updatedDescuento($value){
        if($value){
            $this->descuento_total = ($this->subtotal  * $this->descuento / 100) + $this->descuento_total;
            $this->total_venta = ($this->subtotal  - $this->descuento_total) + $this->iva;
        }
        else{
            $this->descuento = 0;
            $this->total_venta = ($this->subtotal +  $this->iva) - $this->descuento_total;
        } 
    } */

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
        $this->tasa_metodo = tasa_dia::where('moneda_id',2)->first()->tasa;
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
        $this->descuento_total = 0;
        $this->mostrar_total_pagado_bs = 0;
        $this->mostrar_total_pagado_dl = 0;
        $this->mostrar_total_cambio_bs = 0;
        $this->mostrar_total_cambio_dl = 0;
        $this->pendiente_pagar_cliente_bs = 0;
        $this->pendiente_pagar_cliente_dl = 0;
        $total_cambio = 0;
        $moneda_1 = 'bs';
        $moneda_2 = 'bs';
        $moneda_3 = 'bs';


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

       
        $subt = 0;
        $this->subt_e = 0;

        foreach (Cart::content() as $item) {
            if($item->options['exento'] == "No"){
                $subt = $subt + $item->price;
            }
            else{
                $subt = $subt + 0; 
                $this->subt_e = $this->subt_e + $item->price;
            }

            if($item->options['descuento'] != "null"){
                $this->descuento_total = $this->descuento_total + $item->options['descuento'];
            }

        }

        $this->iva= ($this->empresa->impuesto / 100) * $subt;
        $caracter=",";
        if($this->descuento){
            $this->subtotal = (str_replace($caracter,"",Cart::subtotal()));
            $this->descuento_total = ($this->subtotal  * $this->descuento / 100) + $this->descuento_total;
            $this->total_venta = (($this->subtotal  - $this->descuento_total) + $this->iva);
        }
        else{
            $this->subtotal = (str_replace($caracter,"",Cart::subtotal()));
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

        if ($this->cant_metodos == '1'){
            if($this->monto1 != ''){
                if($this->metodo_id_1 == 1 || $this->metodo_id_1 == 2 || $this->metodo_id_1 == 3 || $this->metodo_id_1 == 5 || $this->metodo_id_1 == 6){
                    $this->mostrar_total_pagado_bs  = $this->monto1 + $this->mostrar_total_pagado_bs ;
                    $this->mostrar_total_pagado_dl  = ($this->monto1 / $this->tasa_metodo) + $this->mostrar_total_pagado_dl ;
                    $total_cambio =  ($this->monto1 - $this->total_venta);
                   
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl =0 + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - $this->monto1) + $this->pendiente_pagar_cliente_bs ;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta - $this->monto1) / $this->tasa_metodo) + $this->pendiente_pagar_cliente_dl;
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio +  $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl = ($total_cambio / $this->tasa_metodo) +  $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 + $this->pendiente_pagar_cliente_bs ;
                        $this->pendiente_pagar_cliente_dl = 0 + $this->pendiente_pagar_cliente_dl ;
                    }
                } 
                else{
                    $this->mostrar_total_pagado_bs  = ($this->monto1 * $this->tasa_metodo) + $this->mostrar_total_pagado_bs;
                    $this->mostrar_total_pagado_dl  = $this->monto1 + $this->mostrar_total_pagado_dl ;
                    $total_cambio =  ($this->monto1 - ($this->total_venta / $this->tasa_metodo));
                 //  dd($total_cambio);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl =0 + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - $this->monto1) * $this->tasa_metodo) + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = ((($this->total_venta/ $this->tasa_metodo) - $this->monto1)) + $this->pendiente_pagar_cliente_dl;
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = ($total_cambio * $this->tasa_metodo) + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl = $total_cambio + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = 0 + $this->pendiente_pagar_cliente_bs;
                    }

                }
            }

        }

        elseif ($this->cant_metodos == '2'){
            if($this->monto1 != '' && $this->monto2 == ''){
                if($this->metodo_id_1 == 1 || $this->metodo_id_1 == 2 || $this->metodo_id_1 == 3 || $this->metodo_id_1 == 5 || $this->metodo_id_1 == 6){
                    $this->mostrar_total_pagado_bs  = $this->monto1 + $this->mostrar_total_pagado_bs ;
                    $this->mostrar_total_pagado_dl  = ($this->monto1 / $this->tasa_metodo) + $this->mostrar_total_pagado_dl;
                    $total_cambio =  ($this->monto1 - $this->total_venta);
                   
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl =0 + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - $this->monto1) + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta - $this->monto1) / $this->tasa_metodo) + $this->pendiente_pagar_cliente_dl;
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl = ($total_cambio / $this->tasa_metodo) + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = 0 + $this->pendiente_pagar_cliente_dl;
                    }
                } 
                else{
                    $this->mostrar_total_pagado_bs  = ($this->monto1 * $this->tasa_metodo) +  $this->mostrar_total_pagado_bs;
                    $this->mostrar_total_pagado_dl  = $this->monto1 + $this->mostrar_total_pagado_dl;
                    $total_cambio =  ($this->monto1 - ($this->total_venta / $this->tasa_metodo));
                 //  dd($total_cambio);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl =0 + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - $this->monto1) * $this->tasa_metodo) + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = ((($this->total_venta/ $this->tasa_metodo) - $this->monto1)) + $this->pendiente_pagar_cliente_dl;
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = ($total_cambio * $this->tasa_metodo) + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl = $total_cambio + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = 0 + $this->pendiente_pagar_cliente_dl;
                    }

                }
            }
            if($this->monto1 != '' && $this->monto2 != ''){
                if($this->metodo_id_1 == 1 || $this->metodo_id_1 == 2 || $this->metodo_id_1 == 3 || $this->metodo_id_1 == 5 || $this->metodo_id_1 == 6) $moneda_1 = 'bs';
                else $moneda_1 = '$';
                if($this->metodo_id_2 == 1 || $this->metodo_id_2 == 2 || $this->metodo_id_2 == 3 || $this->metodo_id_2 == 5 || $this->metodo_id_2 == 6) $moneda_2 = 'bs';
                else $moneda_2 = '$';

                if($moneda_1 == 'bs' && $moneda_2 == 'bs'){
                    $this->mostrar_total_pagado_bs  = ($this->monto1 + $this->monto2);
                    $this->mostrar_total_pagado_dl  = (($this->monto1 + $this->monto2) / $this->tasa_metodo);
                    $total_cambio =  (($this->monto1 + $this->monto2) - $this->total_venta);
                   
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 ;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - ($this->monto1 + $this->monto2));
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta - ($this->monto1 + $this->monto2)) / $this->tasa_metodo);
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = ($total_cambio / $this->tasa_metodo);
                        $this->pendiente_pagar_cliente_bs = 0 ;
                        $this->pendiente_pagar_cliente_dl = 0 ;
                    }
                } 
                elseif($moneda_1 == 'bs' && $moneda_2 == '$'){
                    $this->mostrar_total_pagado_bs  = (($this->monto2 * $this->tasa_metodo) + $this->monto1);
                    $this->mostrar_total_pagado_dl  = ($this->monto2 + ($this->monto1 / $this->tasa_metodo)) ;
                    $total_cambio =  ($this->monto1 + ($this->monto2 * $this->tasa_metodo)) - $this->total_venta;
                    $total_cambio_dl =  ($this->monto2 + ($this->monto1 / $this->tasa_metodo)) - ($this->total_venta/ $this->tasa_metodo);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - ($this->monto1 + ($this->monto2 * $this->tasa_metodo))) * $this->tasa_metodo) ;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta/ $this->tasa_metodo) - ($this->monto2 + ($this->monto1 / $this->tasa_metodo)));
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = $total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0;
                        $this->pendiente_pagar_cliente_dl = 0;
                    }
                }
                elseif($moneda_1 == '$' && $moneda_2 == 'bs'){
                    $this->mostrar_total_pagado_bs  = (($this->monto1 * $this->tasa_metodo) + $this->monto2);
                    $this->mostrar_total_pagado_dl  = ($this->monto1 + ($this->monto2 / $this->tasa_metodo)) ;
                    $total_cambio =  ($this->monto2 + ($this->monto1 * $this->tasa_metodo)) - $this->total_venta;
                    $total_cambio_dl =  ($this->monto1 + ($this->monto2 / $this->tasa_metodo)) - ($this->total_venta/ $this->tasa_metodo);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - ($this->monto2 + ($this->monto1 * $this->tasa_metodo))) * $this->tasa_metodo) ;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta/ $this->tasa_metodo) - ($this->monto1 + ($this->monto2 / $this->tasa_metodo)));
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = $total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0;
                        $this->pendiente_pagar_cliente_dl = 0;
                    }
                }
                elseif($moneda_1 == '$' && $moneda_2 == '$'){
                    $this->mostrar_total_pagado_bs  = ($this->monto1 + $this->monto2) * $this->tasa_metodo;
                    $this->mostrar_total_pagado_dl  = ($this->monto1 + $this->monto2);
                    $total_cambio =  ((($this->monto1* $this->tasa_metodo) + ($this->monto2* $this->tasa_metodo)) - $this->total_venta);
                    $total_cambio_dl =  ($this->monto1 + $this->monto2) - ($this->total_venta/ $this->tasa_metodo);

                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 ;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - (($this->monto1* $this->tasa_metodo) + ($this->monto2* $this->tasa_metodo)));
                        $this->pendiente_pagar_cliente_dl = ($this->total_venta / $this->tasa_metodo)- ($this->monto1 + $this->monto2);
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = $total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 ;
                        $this->pendiente_pagar_cliente_dl = 0 ;
                    }
                }
            }
        }

        else{
            if($this->monto1 != '' && $this->monto2 == '' && $this->monto3 == ''){
                if($this->metodo_id_1 == 1 || $this->metodo_id_1 == 2 || $this->metodo_id_1 == 3 || $this->metodo_id_1 == 5 || $this->metodo_id_1 == 6){
                    $this->mostrar_total_pagado_bs  = $this->monto1 + $this->mostrar_total_pagado_bs ;
                    $this->mostrar_total_pagado_dl  = ($this->monto1 / $this->tasa_metodo) + $this->mostrar_total_pagado_dl;
                    $total_cambio =  ($this->monto1 - $this->total_venta);
                   
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl =0 + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - $this->monto1) + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta - $this->monto1) / $this->tasa_metodo) + $this->pendiente_pagar_cliente_dl;
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl = ($total_cambio / $this->tasa_metodo) + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = 0 + $this->pendiente_pagar_cliente_dl;
                    }
                } 
                else{
                    $this->mostrar_total_pagado_bs  = ($this->monto1 * $this->tasa_metodo) +  $this->mostrar_total_pagado_bs;
                    $this->mostrar_total_pagado_dl  = $this->monto1 + $this->mostrar_total_pagado_dl;
                    $total_cambio =  ($this->monto1 - ($this->total_venta / $this->tasa_metodo));
                 //  dd($total_cambio);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl =0 + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - $this->monto1) * $this->tasa_metodo) + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = ((($this->total_venta/ $this->tasa_metodo) - $this->monto1)) + $this->pendiente_pagar_cliente_dl;
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = ($total_cambio * $this->tasa_metodo) + $this->mostrar_total_cambio_bs;
                        $this->mostrar_total_cambio_dl = $total_cambio + $this->mostrar_total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 + $this->pendiente_pagar_cliente_bs;
                        $this->pendiente_pagar_cliente_dl = 0 + $this->pendiente_pagar_cliente_dl;
                    }

                }

            }

            elseif($this->monto1 != '' && $this->monto2 != '' && $this->monto3 == ''){
                if($this->metodo_id_1 == 1 || $this->metodo_id_1 == 2 || $this->metodo_id_1 == 3 || $this->metodo_id_1 == 5 || $this->metodo_id_1 == 6) $moneda_1 = 'bs';
                else $moneda_1 = '$';
                if($this->metodo_id_2 == 1 || $this->metodo_id_2 == 2 || $this->metodo_id_2 == 3 || $this->metodo_id_2 == 5 || $this->metodo_id_2 == 6) $moneda_2 = 'bs';
                else $moneda_2 = '$';

                if($moneda_1 == 'bs' && $moneda_2 == 'bs'){
                    $this->mostrar_total_pagado_bs  = ($this->monto1 + $this->monto2);
                    $this->mostrar_total_pagado_dl  = (($this->monto1 + $this->monto2) / $this->tasa_metodo);
                    $total_cambio =  (($this->monto1 + $this->monto2) - $this->total_venta);
                   
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 ;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - ($this->monto1 + $this->monto2));
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta - ($this->monto1 + $this->monto2)) / $this->tasa_metodo);
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = ($total_cambio / $this->tasa_metodo);
                        $this->pendiente_pagar_cliente_bs = 0 ;
                        $this->pendiente_pagar_cliente_dl = 0 ;
                    }
                } 
                elseif($moneda_1 == 'bs' && $moneda_2 == '$'){
                    $this->mostrar_total_pagado_bs  = (($this->monto2 * $this->tasa_metodo) + $this->monto1);
                    $this->mostrar_total_pagado_dl  = ($this->monto2 + ($this->monto1 / $this->tasa_metodo)) ;
                    $total_cambio =  ($this->monto1 + ($this->monto2 * $this->tasa_metodo)) - $this->total_venta;
                    $total_cambio_dl =  ($this->monto2 + ($this->monto1 / $this->tasa_metodo)) - ($this->total_venta/ $this->tasa_metodo);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - ($this->monto1 + ($this->monto2 * $this->tasa_metodo))) * $this->tasa_metodo) ;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta/ $this->tasa_metodo) - ($this->monto2 + ($this->monto1 / $this->tasa_metodo)));
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = $total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0;
                        $this->pendiente_pagar_cliente_dl = 0;
                    }
                }
                elseif($moneda_1 == '$' && $moneda_2 == 'bs'){
                    $this->mostrar_total_pagado_bs  = (($this->monto1 * $this->tasa_metodo) + $this->monto2);
                    $this->mostrar_total_pagado_dl  = ($this->monto1 + ($this->monto2 / $this->tasa_metodo)) ;
                    $total_cambio =  ($this->monto2 + ($this->monto1 * $this->tasa_metodo)) - $this->total_venta;
                    $total_cambio_dl =  ($this->monto1 + ($this->monto2 / $this->tasa_metodo)) - ($this->total_venta/ $this->tasa_metodo);
                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ((($this->total_venta/ $this->tasa_metodo) - ($this->monto2 + ($this->monto1 * $this->tasa_metodo))) * $this->tasa_metodo) ;
                        $this->pendiente_pagar_cliente_dl = (($this->total_venta/ $this->tasa_metodo) - ($this->monto1 + ($this->monto2 / $this->tasa_metodo)));
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = $total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0;
                        $this->pendiente_pagar_cliente_dl = 0;
                    }
                }
                elseif($moneda_1 == '$' && $moneda_2 == '$'){
                    $this->mostrar_total_pagado_bs  = ($this->monto1 + $this->monto2) * $this->tasa_metodo;
                    $this->mostrar_total_pagado_dl  = ($this->monto1 + $this->monto2);
                    $total_cambio =  ((($this->monto1* $this->tasa_metodo) + ($this->monto2* $this->tasa_metodo)) - $this->total_venta);
                    $total_cambio_dl =  ($this->monto1 + $this->monto2) - ($this->total_venta/ $this->tasa_metodo);

                    if($total_cambio<0){
                        $this->mostrar_total_cambio_bs =0 ;
                        $this->mostrar_total_cambio_dl =0 ;
                        $this->pendiente_pagar_cliente_bs = ($this->total_venta - (($this->monto1* $this->tasa_metodo) + ($this->monto2* $this->tasa_metodo)));
                        $this->pendiente_pagar_cliente_dl = ($this->total_venta / $this->tasa_metodo)- ($this->monto1 + $this->monto2);
                    } 
                    else {
                        $this->mostrar_total_cambio_bs = $total_cambio;
                        $this->mostrar_total_cambio_dl = $total_cambio_dl;
                        $this->pendiente_pagar_cliente_bs = 0 ;
                        $this->pendiente_pagar_cliente_dl = 0 ;
                    }
                }

            }
            /*elseif($this->monto1 != '' && $this->monto2 != '' && $this->monto3 != ''){
                if($this->metodo_id_1 == 1 || $this->metodo_id_1 == 2 || $this->metodo_id_1 == 3 || $this->metodo_id_1 == 5 || $this->metodo_id_1 == 6) $moneda_1 = 'bs';
                else $moneda_1 = '$';
                if($this->metodo_id_2 == 1 || $this->metodo_id_2 == 2 || $this->metodo_id_2 == 3 || $this->metodo_id_2 == 5 || $this->metodo_id_2 == 6) $moneda_2 = 'bs';
                else $moneda_2 = '$';
                if($this->metodo_id_3 == 1 || $this->metodo_id_3 == 2 || $this->metodo_id_3 == 3 || $this->metodo_id_3 == 5 || $this->metodo_id_3 == 6) $moneda_3 = 'bs';
                else $moneda_3 = '$';

                if($moneda_1 == 'bs' && $moneda_2 == 'bs' && $moneda_3 == 'bs'){

                }
                elseif($moneda_1 == '$' && $moneda_2 == '$' && $moneda_3 == '$'){
                    
                }



            }*/


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

        /*if($this->cant_metodos == "4"){
            $rules_cant_pago_4 = $this->rules_cant_pago_4;
            $this->validate($rules_cant_pago_4);   
        }

        if($this->cant_metodos == "5"){
            $rules_cant_pago_5 = $this->rules_cant_pago_5;
            $this->validate($rules_cant_pago_5);   
        }*/

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
            if($this->vuelto == 'si'){
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
            $venta->exento = $this->subt_e;
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
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto1),
                    ]);
                }

                if($this->metodo_id_1 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto1),
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
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto2),
                    ]);
                }

                if($this->metodo_id_2 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto2),
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
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto3),
                    ]);
                }

                if($this->metodo_id_3 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto3),
                    ]);
                }
            }
           /* elseif($this->cant_metodos == 4) {
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
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto4),
                    ]);
                }

                if($this->metodo_id_4 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto4),
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
                        'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares + $this->monto5),
                    ]);
                }

                if($this->metodo_id_5 == 4){
                    $this->caja_detalle->update([
                        'saldo_dolares' => ($this->caja_detalle->saldo_dolares + $this->monto5),
                    ]);
                }
            }*/

            $this->caja_detalle->update([
                'saldo_bolivares' => ($this->caja_detalle->saldo_bolivares) - $efectivo_bs_decrec,
            ]);

            $this->caja_detalle->update([
                'saldo_dolares' => ($this->caja_detalle->saldo_dolares) - $efectivo_dls_decrec,
            ]);

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
        if($this->imprimir == '1'){
            $data2 = [
                'empresa_nombre' => $this->empresa->nombre,
                'empresa_tipo_documento' => $this->empresa->tipo_documento,
                'empresa_documento' => $this->empresa->nro_documento,
                'empresa_direccion' => $this->empresa->direccion,
                'empresa_telefono' => $this->empresa->telefono,
                'empresa_email' => $this->empresa->email,
               'cliente_nombre' => $this->client->nombre,
                'cliente_apellido' => $this->client->apellido,
                'cliente_documento' =>$this->client->nro_documento,
                'cliente_tipo_documento' =>$this->client->tipo_documento,
                'cliente_nro_documento' =>$this->client->nro_documento,
                'cajero_nombre' => auth()->user()->name,
                'cajero_apellido' => auth()->user()->apellido,
                'nro_venta' => $venta_nro_p,
                'caja_nombre' => $this->caja_detalle->nombre,
                'iva_empresa' => $this->empresa->impuesto,
                'productos' => Cart::content(),
                'descuento' => $this->descuento_total,
                'subtotal' =>  $this->subtotal,
                'total' => $this->total_venta,
                'tipo_pago' => $this->total_venta,
                'pago_cliente' => $this->tipo_pago,
                'iva' => $this->iva,
            ];
    
          /*  $data = [
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
                'iva' => $this->iva,];*/
    
            //factura
          /*  if($this->tipo_comprobante == "1"){ 
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
            }*/
            //ticket 
    
            if($this->tipo_comprobante == "1"){ 
               
               $json = json_encode($data2);
    
    
               $client = new Client([
                    'base_uri' => 'http://apiprint.test',
                ]);
    
                $client->request('GET', '/api/print_ticket/'.$json);
    
            }
            //nota de entrega
            else{ 
                $json = json_encode($data2);
               
    
                $client = new Client([
                    'base_uri' => 'http://apiprint.test',
                ]);
    
                $client->request('GET', '/api/print_nota/'.$json);
            }


        }

        
        
        cart::destroy();

        $this->client = Cliente::where('id','1')->first();
        $this->cliente_select = $this->client->nombre." ".$this->client->apellido;

        $this->reset(['monto1','monto2','monto3','monto4','monto5','metodo_id_1','metodo_id_2','metodo_id_3','metodo_id_4','metodo_id_5','send_mail','cash_received','total_venta','pago_cliente','descuento','descuento_total','metodo_pago','tipo_pago','estado_entrega','subtotal','vuelto','metodo_cambio_id','monto_vuelto']);
       
        if($this->imprimir == 1){
            $this->reset(['imprimir','tipo_comprobante']);
            $this->emitTo('ventas.ventas-seleccion-productos','render');
            $this->emitTo('ventas.ventas-cart','render');
    
            //GENERANDO PDF
           /*if($this->tipo_comprobante == 1){
                return response()->streamDownload(
                    fn () => print($pdf),
                "Comprobante.pdf"
                );
            }*/
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
