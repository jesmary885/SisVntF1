<?php

namespace App\Http\Livewire\Productos;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Producto_lote;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;

use App\Models\Producto_sucursal as Pivot;
use App\Models\ProductoSerialSucursal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductosAdd extends Component
{

    public $isopen = false;
    public $producto, $lotes, $generar_serial, $pivot, $precio_compra, $proveedores, $cantidad, $sucursal_nombre, $sucursal_id = "", $lote_id = "",$sucursales, $proveedor_id = "";
    public $limitacion_sucursal = true;
    public $fecha_vencimiento,$vencimiento,$observaciones;
    public $utilidad_letal, $utilidad_mayor, $margen_letal, $margen_mayor, $precio_entrada, $precio_letal, $precio_mayor,$act_utilidades="1", $act_old_rol=0;

    protected $listeners = ['render' => 'render'];
      
    protected $rules = [
        'cantidad' => 'required',
        'sucursal_id' => 'required',
        'precio_entrada' => 'required',
        'precio_letal' => 'required',
        'precio_mayor' => 'required',
        'utilidad_letal' => 'required',
        'utilidad_mayor' => 'required',
        'margen_letal' => 'required',
        'margen_mayor' => 'required',
        'proveedor_id' => 'required',
    ];

    public function mount(){
        $this->proveedores=Proveedor::all();
        $this->lotes = Producto_lote::where('producto_id',$this->producto->id)->get();
         $usuario_au = User::where('id',Auth::id())->first();
         $this->vencimiento = Producto::where('id',$this->producto->id)->first()->vencimiento;

         if($usuario_au->limitacion == '1'){
             $this->sucursales=Sucursal::all();
         }else{
             $this->limitacion_sucursal = false;
             $this->sucursal_id = $usuario_au->sucursal_id;
             $sucursal_usuario = Sucursal::where('id',$this->sucursal_id)->first();
             $this->sucursal_nombre = $sucursal_usuario->nombre;
         }
     }
 
    public function render()
    {
        if($this->lote_id != ""){
            if($this->lote_id == "nuevo_lote"){
                if($this->precio_entrada != ''){
                    if($this->act_old_rol == '1'){
                        $this->act_old_rol = 0;
                        $this->reset(['precio_letal','margen_letal','precio_mayor','margen_mayor','precio_entrada','utilidad_letal','utilidad_mayor','fecha_vencimiento']);
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
                $this->margen_mayor = $producto_lote_select->utilidad_mayor;
                $this->margen_letal = $producto_lote_select->margen_letal;
                $this->utilidad_mayor = $producto_lote_select->utilidad_mayor;
                if($this->vencimiento == 'Si') $this->fecha_vencimiento = date("d-m-Y",strtotime($producto_lote_select->fecha_vencimiento));;
            }
        }
        

        return view('livewire.productos.productos-add');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  

        $this->reset(['precio_entrada','sucursal_id','proveedor_id','cantidad','precio_letal','precio_mayor','utilidad_letal','utilidad_mayor','margen_letal','margen_mayor','lote_id']);
    }

    public function save(){
        
        if($this->cantidad < 0 || $this->precio_entrada < 0 || $this->precio_letal < 0 || $this->precio_mayor < 0 || $this->utilidad_letal < 0 || $this->utilidad_mayor < 0 || $this->margen_letal < 0 || $this->margen_mayor < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
           // $this->reset(['precio_compra','cantidad']);
        }else{
            $sucursales = Sucursal::all();
            $producto_select = Producto::where('id',$this->producto->id)->first();
            $cantidad_nueva_general = $producto_select->cantidad + $this->cantidad;
            $this->fecha_actual = date('Y-m-d');
            $usuario_auth = Auth::id();
            $total_compra = ($this->precio_compra * $this->cantidad);

            $rules = $this->rules;
            $this->validate($rules);

            //Guardando movimiento de producto para kardex

            $stock_antiguo = 0;
            foreach($sucursales as $sucursalx){
                $stock_antiguo = $this->producto->sucursals->find($sucursalx)->pivot->cantidad + $stock_antiguo;
            }

            $stock_nuevo = $stock_antiguo + $this->cantidad;
            
            $producto_select->update([
                'cantidad' => $stock_nuevo,
            ]);

            $producto_select->movimientos()->create([
                'fecha' => $this->fecha_actual,
                'cantidad_entrada' => $this->cantidad,
                'cantidad_salida' => 0,
                'stock_antiguo' => $stock_antiguo,
                'stock_nuevo' => $stock_nuevo,
                'precio_entrada' => $this->precio_compra * $this->cantidad,
                'precio_salida' => 0,
                'detalle' => 'Compra y registro de nuevas unidades',
                'user_id' => $usuario_auth
            ]);


            //modificando cantidad en tabla pivote producto_sucursal
            $cantidad_nueva_sucursal = $this->producto->sucursals->find($this->sucursal_id)->pivot->cantidad + $this->cantidad;
            $pivot = Pivot::where('sucursal_id',$this->sucursal_id)
                            ->where('producto_id',$producto_select->id)
                            ->first();
            $pivot->cantidad = $cantidad_nueva_sucursal;
            $pivot->save();
            
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
            $compra->save();

            //Agregando en tabla de producto_lote

            if($this->lote_id == "nuevo_lote"){
                $old_producto_lote_select = Producto_lote::where('producto_id',$this->producto->id)
                    ->first();
                
                $new_lote = $old_producto_lote_select->lote + 1;

                $nuevo_lote_producto = new Producto_lote();
                $nuevo_lote_producto->lote = $new_lote;
                $nuevo_lote_producto->proveedor_id = $this->proveedor_id;
                $nuevo_lote_producto->producto_id = $producto_select->id;
                $nuevo_lote_producto->fecha_vencimiento = Carbon::parse($this->fecha_vencimiento); 
                $nuevo_lote_producto->precio_entrada = $this->precio_entrada;
                $nuevo_lote_producto->precio_letal = $this->precio_letal;
                $nuevo_lote_producto->precio_mayor = $this->precio_mayor;
                $nuevo_lote_producto->utilidad_letal = $this->utilidad_letal;
                $nuevo_lote_producto->margen_letal = $this->margen_letal;
                $nuevo_lote_producto->utilidad_mayor = $this->utilidad_mayor;
                $nuevo_lote_producto->margen_mayor = $this->margen_mayor;
                $nuevo_lote_producto->stock = $this->cantidad;
                $nuevo_lote_producto->observaciones = $this->observaciones;
                $nuevo_lote_producto->save();

            }else{
                $producto_lote_select = Producto_lote::where('producto_id',$this->producto->id)
                    ->where('lote',$this->lote_id)
                    ->first();
                
                $producto_lote_select->update([
                    'proveedor_id' => $this->proveedor_id,
                    'stock' => $producto_lote_select->stock + $this->cantidad,
                ]);
            }

            //agregando productos si contienen serial en tabla producto_cod_barra_serials
        /*  if($producto_select->serial == '1'){
                for ($i=0; $i < $this->cantidad; $i++) {
                    $producto_select->producto_cod_barra_serials()->create([
                        'serial' => '',
                        'sucursal_id' => $this->sucursal_id
                    ]);
                }
            }*/

            //agregando productos a la tabla productosSerialSucursal

            $this->reset(['isopen','precio_compra','sucursal_id','proveedor_id','cantidad']);
            $this->emitTo('productos.productos-index','render');
            $this->emit('alert','Datos registrados correctamente');

        }
        
    }
}
