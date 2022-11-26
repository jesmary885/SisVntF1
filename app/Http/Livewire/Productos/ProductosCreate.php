<?php

namespace App\Http\Livewire\Productos;

use App\Models\Caja;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Marca;
use App\Models\Metodo_pago;
use App\Models\Modelo;
use App\Models\Moneda;
use App\Models\Movimiento;
use App\Models\MovimientoCaja;
use App\Models\Producto;
use App\Models\Producto_cod_barra_serial;
use App\Models\Producto_lote;
use App\Models\Producto_sucursal;
use App\Models\ProductoSerialSucursal;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\tasa_dia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\Str;


class ProductosCreate extends Component
{

    use WithFileUploads;

    public $total_pagar,$nombre,$tipo_pago=0, $monedas, $moneda_id= 1, $puntos, $generar_serial, $fecha_actual, $sucursal_nombre, $cantidad, $observaciones, $inv_min, $cod_barra, $inventario_min, $presentacion, $precio_entrada, $precio_letal, $precio_mayor, $tipo_garantia, $garantia, $estado, $file, $marcas, $categorias, $proveedores, $sucursales;
    public $modelos = [],$tasa_dia,$moneda_nombre,$moneda_simbolo, $metodos, $metodo_id, $saldado_proveedor = 1, $pago;
    public $marca_id = "", $sucursal_id = "" ,$modelo_id = "", $categoria_id = "", $proveedor_id ="",$cajas = [], $caja_id="";
    public $limitacion_sucursal = true,$precio_combo,$utilidad_combo,$margen_combo;
    public $ff, $fecha_vencimiento, $descuento, $stock_minimo, $vencimiento = "no", $unidad_tiempo_garantia;
    public $moneda_select,$utilidad_letal, $utilidad_mayor, $margen_letal, $margen_mayor, $act_utilidades="1", $act_margenes, $exento;

    protected $listeners = ['refreshimg'];

    protected $rules = [
         'nombre' => 'required|unique:productos',
         'cod_barra'=>'unique:productos|max:25',
         /*'precio_entrada' => 'required|numeric',
         'precio_letal' => 'required|numeric',
         'precio_mayor' => 'required|numeric',
         'utilidad_letal' => 'required|numeric',
         'margen_letal' => 'required|numeric',
         'utilidad_mayor' => 'required|numeric',
         'margen_mayor' => 'required|numeric',*/
         'cantidad' => 'required|numeric',
         'categoria_id' => 'required',
         'marca_id' => 'required',
         'modelo_id' => 'required',
         'proveedor_id' => 'required',
         'sucursal_id' => 'required',
         'estado' => 'required',
         'presentacion' => 'required',
         'stock_minimo' => 'required|numeric',
         'vencimiento' => 'required',
         'tipo_garantia' => 'required',
         'file' => 'max:1024',
         'tipo_pago' => 'required'
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

      protected $rule_file = [
        'file' => 'image|max:1024',
     ];

    public function mount(){
        $this->moneda_id = '1';

        $usuario_au = User::where('id',Auth::id())->first();
        if($usuario_au->limitacion == '1'){
            $this->sucursales=Sucursal::where('status',1)->get();
        }else{
            $this->limitacion_sucursal = false;
            $this->sucursal_id = $usuario_au->sucursal_id;
            $sucursal_usuario = Sucursal::where('id',$this->sucursal_id)->first();
            $this->sucursal_nombre = $sucursal_usuario->nombre;
            $this->cajas = Caja::where('sucursal_id',$this->sucursal_id)->get();
        }

        $this->marcas=Marca::all();
        $this->categorias=Categoria::all();
        $this->proveedores=Proveedor::all();
        $this->monedas = Moneda::all();
        $this->metodos = Metodo_pago::all();

        

        $this->moneda_select = 'Bs'; 

    }

    public function updatedSucursalId($value)
    {
        $sucursal_select = Sucursal::find($value);
        $this->cajas = $sucursal_select->cajas;
    }

    public function updatedMonedaId($value)
    {
        $moneda_bdd = Moneda::where('id',$value)->first();
        $this->moneda_select = $moneda_bdd->simbolo;
    }

    public function updatedMarcaId($value)
    {
        $marca_select = Marca::find($value);
        $this->modelos = $marca_select->modelos;
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'image|max:1024',
        ]);
    }

    public function save()
    {
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

        $sucursales = Sucursal::all();

        $this->fecha_actual = date('Y-m-d');
        $usuario_auth = Auth::id();
        
        if($this->observaciones == '') $this->observaciones = 'Sin observaciones';

        if($this->precio_entrada < 0 || $this->precio_letal < 0 || $this->precio_mayor < 0 || $this->cantidad < 0 || $this->puntos < 0 || $this->utilidad_combo < 0 || $this->margen_combo < 0 || $this->precio_combo < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
        }
        else{

            if($this->moneda_id == '1') $tasa_dia = 1;
            else $tasa_dia = tasa_dia::where('moneda_id',$this->moneda_id)->first()->tasa; 
            
            

            //agregando producto en tabla productos
            $producto = new Producto();
            $producto->nombre = $this->nombre;
            if($this->cod_barra) $producto->cod_barra = $this->cod_barra;
            else $producto->cod_barra = Str::random(8);
            $producto->presentacion = $this->presentacion;
            $producto->modelo_id = $this->modelo_id;
            $producto->marca_id = $this->marca_id;
            $producto->cantidad= $this->cantidad;
            $producto->categoria_id = $this->categoria_id;
            $producto->estado = $this->estado;
            $producto->stock_minimo = $this->stock_minimo;
            $producto->descuento = $this->descuento;
            $producto->vencimiento = $this->vencimiento;
            $producto->unidad_tiempo_garantia = $this->unidad_tiempo_garantia;
            $producto->tipo_garantia = $this->tipo_garantia;
            if($this->exento == '1')  $producto->exento = 'Si';
            else $producto->exento = 'No';
            $producto->save();

            //agregando imagen de producto en tabla imagenes
            if ($this->file){
                    $rule_file = $this->rule_file;
                    $this->validate($rule_file);
                    $url = Storage::put('public/productos', $this->file);
                    $producto->imagen()->create([
                        'url' => $url
                    ]);
                }
            
            $total_compra = ($this->precio_entrada) * $this->cantidad;

            if($this->tipo_pago == 1)$deuda_proveedor = $total_compra - $this->pago;
            elseif($this->tipo_pago == 2) $deuda_proveedor = $total_compra;
            else $deuda_proveedor = 0;

            //registrando compra en tabla compras
            $compra = new Compra();
            $compra->fecha = $this->fecha_actual;
            $compra->total = $total_compra;
            $compra->cantidad = $this->cantidad;
            if($this->precio_entrada) $compra->precio_compra = $this->precio_entrada; else $compra->precio_compra = 0;
            $compra->proveedor_id = $this->proveedor_id;
            $compra->user_id = $usuario_auth;
            $compra->sucursal_id = $this->sucursal_id;
            $compra->producto_id = $producto->id;
            $compra->deuda_a_proveedor = $deuda_proveedor;
            if($this->tipo_pago == '1' || $this->tipo_pago == '3'){
                $compra->caja_id = $this->caja_id;
            }
            $compra->moneda_id = $this->moneda_id;
            $compra->lote = '1';
            $compra->save();

            //registrando en tabla producto_lotes
            $lote = new Producto_lote();
            $lote->lote = '1';
            $lote->proveedor_id = $this->proveedor_id;
            $lote->producto_id = $producto->id;
            $lote->fecha_vencimiento = Carbon::parse($this->fecha_vencimiento);
            if($this->precio_entrada) $lote->precio_entrada = $this->precio_entrada; else $lote->precio_entrada = 0;
            if($this->precio_letal) $lote->precio_letal = $this->precio_letal*$tasa_dia; else $lote->precio_letal = 0;
            if($this->precio_mayor) $lote->precio_mayor = $this->precio_mayor*$tasa_dia; else $lote->precio_mayor = 0;
            if($this->utilidad_letal) $lote->utilidad_letal = $this->utilidad_letal*$tasa_dia; else $lote->utilidad_letal = 0;
            if($this->utilidad_mayor) $lote->utilidad_mayor = $this->utilidad_mayor*$tasa_dia; else $lote->utilidad_mayor = 0;
            if($this->utilidad_combo) $lote->utilidad_combo = $this->utilidad_combo*$tasa_dia; else $lote->utilidad_combo = 0;
            if($this->precio_combo) $lote->precio_combo= $this->precio_combo*$tasa_dia; else $lote->precio_combo= 0;
            if($this->margen_combo) $lote->margen_combo = $this->margen_combo*$tasa_dia; else $lote->margen_combo = 0;
            if($this->margen_letal) $lote->margen_letal = $this->margen_letal*$tasa_dia; else $lote->margen_letal = 0;
            if($this->margen_mayor) $lote->margen_mayor = $this->margen_mayor*$tasa_dia; else $lote->margen_mayor = 0;
            $lote->moneda_id =$this->moneda_id;
            $lote->tasa_venta = $tasa_dia;
            $lote->status = 'activo';
            $lote->observaciones = $this->observaciones;
            $lote->stock= $this->cantidad;
            $lote->save();
           
            //registrando moviemientos en tabla movimientos
            $producto->movimientos()->create([
                'fecha' => $this->fecha_actual,
                'cantidad_entrada' => $this->cantidad,
                'stock_antiguo' => 0,
                'stock_nuevo' => $this->cantidad,
                'cantidad_salida' => 0,
                'precio_entrada' => $total_compra,
                'precio_salida' => 0,
                'detalle' => 'Registro de producto',
                'user_id' => $usuario_auth
            ]);

            //guardando cantidades en tabla pivote entre sucursal y productos
            foreach($sucursales as $sucursal){
                if($sucursal->id == $this->sucursal_id){
                    $producto->sucursals()->attach([
                        $this->sucursal_id => [
                            'cantidad' => $this->cantidad,
                            'lote' => 1,
                            'status' => 'activo'
                        ]
                    ]);
                }else{
                    $producto->sucursals()->attach([
                        $sucursal->id => [
                            'cantidad' => 0,
                            'lote' => 1,
                            'status' => 'activo'
                        ]
                    ]);
                }
            }
            //registrar movimiento de egreso en tabla de movimiento_caja
            if($this->tipo_pago != '2'){
                $movimiento_caja = new MovimientoCaja();
                $movimiento_caja->fecha = $this->fecha_actual;
                $movimiento_caja->tipo_movimiento = 2;
                $movimiento_caja->cantidad = $total_compra;
                $movimiento_caja->estado = 'etregado';
                $movimiento_caja->observacion = 'Compra de producto';
                $movimiento_caja->user_id = $usuario_auth;
                $movimiento_caja->sucursal_id = $this->sucursal_id;
                $movimiento_caja->caja_id = $this->caja_id;
                $movimiento_caja->save();
            }
            
            $this->reset(['nombre','stock_minimo','utilidad_letal','utilidad_mayor','margen_letal','margen_mayor','exento','descuento','sucursal_id','fecha_vencimiento','generar_serial','puntos','cantidad','cod_barra','inventario_min','presentacion','precio_entrada','precio_letal','precio_mayor','modelo_id','categoria_id','observaciones','tipo_garantia','garantia','estado','proveedor_id','marca_id','file','total_pagar','tipo_pago','pago','utilidad_combo','margen_combo','precio_combo']);
            $this->emit('alert','Producto creado correctamente');
            $this->emitTo('productos.productos-index','render');
        }
    }

    public function render()
    {
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

        if($this->precio_entrada != ''){
            /*if($this->moneda_id == '1') $this->tasa_dia = 1;
            else $this->tasa_dia = tasa_dia::where('moneda_id',$this->moneda_id)->first()->tasa;     

            $this->precio_entrada = $this->precio_entrada / $this->tasa_dia;*/

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

        
        return view('livewire.productos.productos-create');
    }
}
