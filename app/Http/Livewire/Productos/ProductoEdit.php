<?php

namespace App\Http\Livewire\Productos;

use App\Models\Categoria;
use App\Models\Imagen;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Producto_lote;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Producto_sucursal as Pivot;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;


class ProductoEdit extends Component
{
    use WithFileUploads;
    public $isopen = false;
    public $pivot, $nombre, $p, $puntos, $fecha_actual, $sucursal_nombre, $cantidad, $observaciones, $cod_barra, $inventario_min, $presentacion, $precio_entrada, $precio_letal, $precio_mayor, $tipo_garantia, $garantia, $estado, $file, $marcas, $categorias, $modelos, $proveedores, $sucursales,$producto;
    public $marca_id = "", $sucursal_id = "" ,$modelo_id = "", $categoria_id = "", $proveedor_id ="";
    public $limitacion_sucursal = true, $exento;

    protected $rules = [
        'categoria_id' => 'required',
        'marca_id' => 'required',
        'modelo_id' => 'required',
        'sucursal_id' => 'required',
        'estado' => 'required',
       // 'puntos' => 'required',
        'nombre' => 'required',
        'vencimiento' => 'required',
        'presentacion' => 'required',
        'stock_minimo' => 'required',
        'tipo_garantia' => 'required',
     ];

    public function updatedMarcaId($value)
    {
        $marca_select = Marca::find($value);
        $this->modelos = $marca_select->modelos;
    }

   
    public function mount($producto){
        $this->p = $producto;

         $usuario_au = User::where('id',Auth::id())->first();
         if($usuario_au->limitacion == '1'){
             $this->sucursales=Sucursal::all();
             $this->sucursal_id = '1';
         }else{
             $this->limitacion_sucursal = false;
             $this->sucursal_id = $usuario_au->sucursal_id;
             $sucursal_usuario = Sucursal::where('id',$this->sucursal_id)->first();
             $this->sucursal_nombre = $sucursal_usuario->nombre;
         }
         $this->nombre = $this->producto->nombre;
         $this->cod_barra = $this->producto->cod_barra;
         $this->precio_letal = $this->producto->precio_letal;
         $this->precio_mayor = $this->producto->precio_mayor;
         //$this->cantidad = $this->producto->sucursals->find($this->sucursal_id)->pivot->cantidad;
         $this->stock_minimo = $this->producto->stock_minimo;
         $this->modelo_id = $this->producto->modelo_id;
         $this->categoria_id = $this->producto->categoria_id;
         $this->tipo_garantia = $this->producto->tipo_garantia;
         $this->descuento = $this->producto->descuento;
         $this->marca_id = $this->producto->marca_id;
         //$this->puntos = $this->producto->puntos;
         $this->vencimiento = $this->producto->vencimiento;
         $this->presentacion = $this->producto->presentacion;
         $this->observaciones = $this->producto->observaciones;
         $this->tipo_garantia = $this->producto->tipo_garantia;
         $this->unidad_tiempo_garantia = $this->producto->unidad_tiempo_garantia;
         $this->estado = $this->producto->estado;
         $this->exento = $this->producto->exento;
         $this->modelos=Modelo::all();
         $this->marcas=Marca::all();
         $this->categorias=Categoria::all();
         $this->proveedores=Proveedor::all();
     }

    public function render()
    {
        return view('livewire.productos.producto-edit');
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
        $rules = $this->rules;
        $this->validate($rules);

        $rule_cod_barra = [
            'cod_barra'=>'required|unique:productos,cod_barra,' .$this->producto->id,
        ];

        //$this->validate($rule_nombre);
        $this->validate($rule_cod_barra);
        $this->fecha_actual = date('Y-m-d');
        $usuario_auth = Auth::id();
           
        if($this->observaciones == '') $this->observaciones = 'Sin observaciones';

        if($this->precio_letal < 0 || $this->precio_mayor < 0 || $this->puntos < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
        }
        else{
            $this->producto->update([
                'nombre' => $this->nombre,
                'cod_barra' => $this->cod_barra,
                'modelo_id' => $this->modelo_id,
                'categoria_id' => $this->categoria_id,
                //'puntos' => $this->puntos,
                'marca_id' => $this->marca_id,
                'observaciones' => $this->observaciones,
                'estado' => $this->estado,
                'stock_minimo' => $this->stock_minimo,
                'presentacion' => $this->presentacion,
                'descuento' => $this->descuento,
                'vencimiento' => $this->vencimiento,
                'tipo_garantia' => $this->tipo_garantia,
                'unidad_tiempo_garantia' => $this->unidad_tiempo_garantia
            ]);

            if($this->vencimiento == "no"){
                $lote = Producto_lote::where('producto_id',$this->producto->id)->first();
                $lote->update([
                    'fecha_vencimiento' => 'NULL',
                ]);
            }

            if ($this->file){
                $imagen = Imagen::where('imageable_id',$this->producto->id)->first();
                $url = Storage::put('public/productos', $this->file);
                if($imagen) $this->producto->imagen()->update(['url' => $url]);
                else $this->producto->imagen()->create(['url' => $url]);
             }

            $this->reset(['isopen']);
            $this->emitTo('productos.productos-index','render');
            $this->emit('alert','Producto modificado correctamente');
        }
    }
}
