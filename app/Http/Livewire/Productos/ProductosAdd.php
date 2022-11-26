<?php

namespace App\Http\Livewire\Productos;

use App\Models\Caja;
use App\Models\Compra;
use App\Models\Metodo_pago;
use App\Models\Moneda;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\Producto_lote;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;

use App\Models\Producto_sucursal as Pivot;
use App\Models\ProductoSerialSucursal;
use App\Models\tasa_dia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ProductosAdd extends Component
{

    public $total_pagar, $isopen = false,$tasa_dia,$moneda_nombre,$moneda_simbolo, $monedas, $moneda_id= 1, $metodos, $metodo_id, $saldado_proveedor = 1, $pago;
    public $moneda_select,$producto, $lotes, $generar_serial, $pivot, $precio_compra, $proveedores, $cantidad, $sucursal_nombre, $sucursal_id = "", $lote_id = "",$sucursales, $proveedor_id = "";
    public $limitacion_sucursal = true, $cajas = [], $caja_id="";
    public $fecha_vencimiento,$vencimiento,$observaciones,$precio_combo,$utilidad_combo,$margen_combo;
    public $tipo_pago = 0, $moneda_lote, $utilidad_letal, $utilidad_mayor, $margen_letal, $margen_mayor, $precio_entrada, $precio_letal, $precio_mayor,$act_utilidades="1", $act_old_rol=0;

    protected $listeners = ['render' => 'render'];
      
    protected $rules = [
        'cantidad' => 'required',
        'sucursal_id' => 'required',
        'lote_id' => 'required',
        'precio_entrada' => 'required',
        'precio_letal' => 'required',
        'precio_mayor' => 'required',
        'utilidad_letal' => 'required',
        'utilidad_mayor' => 'required',
        'margen_letal' => 'required',
        'margen_mayor' => 'required',
        'proveedor_id' => 'required',
        'tipo_pago' => 'required',
    ];

    protected $rule_pago = [
        'pago' => 'required',
        'metodo_id' => 'required',
        'caja_id' => 'required',
    ];
    protected $rule_metodo_pago = [
        'metodo_id' => 'required',
        'caja_id' => 'required',
    ];

    public function updatedMonedaId($value)
    {
        $moneda_bdd = Moneda::where('id',$value)->first();
        $this->moneda_select = $moneda_bdd->simbolo;
    }

    public function mount(){
        $this->moneda_id = '1';
        $this->proveedores=Proveedor::all();
        $this->lotes = Producto_lote::where('producto_id',$this->producto->id)
            ->where('status','activo')
            ->get();

         $usuario_au = User::where('id',Auth::id())->first();
         $this->vencimiento = Producto::where('id',$this->producto->id)->first()->vencimiento;

         if($usuario_au->limitacion == '1'){
             $this->sucursales=Sucursal::all();
         }else{
             $this->limitacion_sucursal = false;
             $this->sucursal_id = $usuario_au->sucursal_id;
             $sucursal_usuario = Sucursal::where('id',$this->sucursal_id)->first();
             $this->sucursal_nombre = $sucursal_usuario->nombre;
             $this->cajas = Caja::where('sucursal_id',$this->sucursal_id)->get();

         }

         $this->monedas = Moneda::all();
         $this->metodos = Metodo_pago::all();

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

        $this->moneda_select = 'Bs'; 
     }

     public function updatedSucursalId($value)
    {
       $sucursal_select = Sucursal::find($value);
        $this->cajas = $sucursal_select->cajas;
    }
 
    public function render()
    {

        if($this->lote_id != ""){
            if($this->lote_id == "nuevo_lote"){
                if($this->precio_entrada != ''){
                    if($this->act_old_rol == '1'){
                        $this->act_old_rol = 0;
                        $this->reset(['precio_letal','margen_letal','precio_mayor','margen_mayor','precio_entrada','utilidad_letal','utilidad_mayor','fecha_vencimiento','utilidad_combo','margen_combo','precio_combo']);
                    }

                    if($this->cantidad != ''){
                        $this->total_pagar = ($this->precio_entrada * $this->cantidad);
                    } 
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
                        if($this->margen_combo != ''){
                            $this->reset(['precio_combo','utilidad_combo']);
                            $this->precio_combo = round(($this->precio_entrada / (1- ($this->margen_combo / 100))),2);
                            $this->utilidad_combo = round(($this->precio_combo - $this->precio_entrada),2);
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
                        if($this->utilidad_combo != ''){
                            $this->reset(['precio_combo','margen_combo']);
                            $this->precio_combo = round(($this->precio_entrada + $this->utilidad_combo),2);
                            $this->margen_combo = round((($this->utilidad_combo / $this->precio_combo) * 100),2);
                        }
                    }
                }
            }
    
            else{
                $this->act_old_rol = 1;
                $producto_lote_select = Producto_lote::where('producto_id',$this->producto->id)
                    ->where('lote',$this->lote_id)
                    ->first();
                $this->precio_letal = $producto_lote_select->precio_letal;
                $this->utilidad_letal = $producto_lote_select->utilidad_letal;
                $this->precio_entrada = $producto_lote_select->precio_entrada;
                $this->precio_mayor = $producto_lote_select->precio_mayor;
                $this->precio_combo = $producto_lote_select->precio_combo;
                $this->margen_mayor = $producto_lote_select->utilidad_mayor;
                $this->margen_letal = $producto_lote_select->margen_letal;
                $this->margen_combo = $producto_lote_select->margen_combo;
                $this->utilidad_mayor = $producto_lote_select->utilidad_mayor;
                $this->utilidad_combo = $producto_lote_select->utilidad_combo;
                $this->moneda_id = $producto_lote_select->moneda_id;
                $this->moneda_select = $producto_lote_select->moneda->simbolo;
                $this->moneda_lote = $producto_lote_select->moneda->simbolo; 
                if($this->vencimiento == 'Si') $this->fecha_vencimiento = date("d-m-Y",strtotime($producto_lote_select->fecha_vencimiento));
            
            }

            if($this->cantidad != ''){
                $this->total_pagar = ($this->precio_entrada * $this->cantidad);
         } 
        }

       // if($this->lote_id != 'nuevo_lote') $this->moneda_lote = 'Bs'; 

       /*if($this->lote_id != 'nuevo_lote'){
            $this->moneda_lote = $producto_lote_select->moneda->simbolo; 
           // $this->moneda_id = 1;    
       } */

        return view('livewire.productos.productos-add');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  

        $this->reset(['precio_entrada','sucursal_id','proveedor_id','cantidad','precio_letal','precio_mayor','utilidad_letal','utilidad_mayor','margen_letal','margen_mayor','lote_id','margen_combo','precio_combo','utilidad_combo']);
    }

    public function save(){
        
        if($this->cantidad < 0 || $this->precio_entrada < 0 || $this->precio_letal < 0 || $this->precio_mayor < 0 || $this->utilidad_letal < 0 || $this->utilidad_mayor < 0 || $this->margen_letal < 0 || $this->margen_mayor < 0 || $this->utilidad_combo < 0 || $this->margen_combo < 0 || $this->precio_combo < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
           // $this->reset(['precio_compra','cantidad']);
        }else{

            //validaciones
           $rules = $this->rules;
            $this->validate($rules);

            if($this->tipo_pago == '1'){
                $rule_pago = $this->rule_pago;
                $this->validate($rule_pago);
            }

            if($this->tipo_pago == '3'){
            $rules_metodo = $this->rule_metodo_pago;
            $this->validate($rules_metodo);
            }

            if($this->moneda_id == '1') $tasa_dia = 1;
            else $tasa_dia = tasa_dia::where('moneda_id',$this->moneda_id)->first()->tasa;            

            $sucursales = Sucursal::all();
            $producto_select = Producto::where('id',$this->producto->id)->first();
            $cantidad_nueva_general = $producto_select->cantidad + $this->cantidad;
            $this->fecha_actual = date('Y-m-d');
            $usuario_auth = Auth::id();

            $total_compra = (($this->precio_entrada) * $this->cantidad);
            $stock_nuevo = $producto_select->cantidad + $this->cantidad;
            
            //Guardando movimiento de producto para kardex
            $producto_select->movimientos()->create([
                'fecha' => $this->fecha_actual,
                'cantidad_entrada' => $this->cantidad,
                'cantidad_salida' => 0,
                'stock_antiguo' => $producto_select->cantidad,
                'stock_nuevo' => $stock_nuevo,
                'precio_entrada' =>$total_compra,
                'precio_salida' => 0,
                'detalle' => 'Compra y registro de nuevas unidades',
                'user_id' => $usuario_auth
            ]);

            //modificando cantidad en tabla de productos
            $producto_select->update([
                'cantidad' => $stock_nuevo,
            ]);

            //Agregando en tabla de producto_lote

            if($this->lote_id == "nuevo_lote"){

                $old_producto_lote_select = Producto_lote::where('producto_id',$this->producto->id)
                ->get()->last();
                
                $new_lote = $old_producto_lote_select->lote + 1;

                $nuevo_lote_producto = new Producto_lote();
                $nuevo_lote_producto->lote = $new_lote;
                $nuevo_lote_producto->proveedor_id = $this->proveedor_id;
                $nuevo_lote_producto->producto_id = $producto_select->id;
                $nuevo_lote_producto->fecha_vencimiento = Carbon::parse($this->fecha_vencimiento); 
                $nuevo_lote_producto->precio_entrada = $this->precio_entrada;
                $nuevo_lote_producto->moneda_id = $this->moneda_id;
                $nuevo_lote_producto->precio_letal = $this->precio_letal*$tasa_dia;
                $nuevo_lote_producto->precio_mayor = $this->precio_mayor*$tasa_dia;
                $nuevo_lote_producto->utilidad_letal = $this->utilidad_letal*$tasa_dia;
                $nuevo_lote_producto->margen_letal = $this->margen_letal;
                $nuevo_lote_producto->utilidad_mayor = $this->utilidad_mayor*$tasa_dia;
                $nuevo_lote_producto->margen_mayor = $this->margen_mayor;
                if($this->utilidad_combo) $this->utilidad_combo*$tasa_dia;
                if($this->precio_combo) $this->precio_combo*$tasa_dia;
                if($this->margen_combo) $this->margen_combo*$tasa_dia;
                $nuevo_lote_producto->stock = $this->cantidad;
                $nuevo_lote_producto->tasa_venta = $tasa_dia;
                $nuevo_lote_producto->status = 'activo';
                $nuevo_lote_producto->observaciones = $this->observaciones;
                $nuevo_lote_producto->save();

            }else{
                $producto_lote_select = Producto_lote::where('producto_id',$this->producto->id)
                    ->where('lote',$this->lote_id)
                    ->first();

                $new_lote = $this->lote_id;
                
                $producto_lote_select->update([
                    'proveedor_id' => $this->proveedor_id,
                    'stock' => $producto_lote_select->stock + $this->cantidad,
                ]);
            }

            //agregando compra
            $compra = new Compra();
            $compra->fecha = $this->fecha_actual;
            $compra->total = $total_compra;
            $compra->cantidad = $this->cantidad;
            $compra->precio_compra = $this->precio_entrada;
            $compra->proveedor_id = $this->proveedor_id;
            $compra->user_id = $usuario_auth;
            $compra->sucursal_id = $this->sucursal_id;
            $compra->producto_id = $producto_select->id;
            $compra->metodo_pago_id = $this->metodo_id;
            $compra->lote=$new_lote;
            $compra->moneda_id = $this->moneda_id;
            if($this->tipo_pago == '1'){
                $compra->deuda_a_proveedor = $total_compra - $this->pago;
                $compra->caja_id = $this->caja_id;
            }
            elseif($this->tipo_pago == '2'){
                $compra->deuda_a_proveedor = $total_compra;
            }
            else{
                $compra->caja_id = $this->caja_id;
            }
            $compra->save();

            //guardando en tabla pivote de sucursal con producto
            if($this->lote_id == "nuevo_lote"){
                foreach($sucursales as $sucursal){
                    if($sucursal->id == $this->sucursal_id){
                        $producto_select->sucursals()->attach([
                            $this->sucursal_id => [
                                'cantidad' => $this->cantidad,
                                'lote' => $new_lote,
                                'status' => 'activo'
                            ]
                        ]);
                    }else{
                        $producto_select->sucursals()->attach([
                            $sucursal->id => [
                                'cantidad' => 0,
                                'lote' => $new_lote,
                                'status' => 'activo'
                            ]
                        ]);
                    }
                }
            }
            else{
                $pivot = Pivot::where('sucursal_id',$this->sucursal_id)
                            ->where('producto_id',$producto_select->id)
                            ->where('lote',$this->lote_id )
                            ->first();
                $pivot->cantidad = $pivot->cantidad + $this->cantidad;
                $pivot->save();
            }

             //registrar movimiento de egreso en tabla de movimiento_caja

             if($this->tipo_pago != '2'){ 
                $movimiento_caja = new MovimientoCaja();
                $movimiento_caja->fecha = $this->fecha_actual;
                $movimiento_caja->tipo_movimiento = 2;
                if($this->saldado_proveedor == '1') $movimiento_caja->cantidad = $total_compra;
                else $movimiento_caja->cantidad = $this->pago;
                $movimiento_caja->estado = 'etregado';
                $movimiento_caja->observacion = 'Compra de producto';
                $movimiento_caja->user_id = $usuario_auth;
                $movimiento_caja->sucursal_id = $this->sucursal_id;
                $movimiento_caja->caja_id = $this->caja_id;
                $movimiento_caja->save();
             }

            $this->reset(['isopen','precio_compra','sucursal_id','proveedor_id','cantidad']);
            $this->emitTo('productos.productos-index','render');
            $this->emit('alert','Datos registrados correctamente');

        }
        
    }
}
