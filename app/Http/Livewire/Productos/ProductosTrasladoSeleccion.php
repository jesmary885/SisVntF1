<?php

namespace App\Http\Livewire\Productos;

use App\Models\Producto;
use App\Models\ProductosTraslado;
use App\Models\Sucursal;
use App\Models\Traslado;
use Livewire\WithPagination;
use App\Models\Producto_sucursal as Pivot;

use Livewire\Component;

class ProductosTrasladoSeleccion extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $isopen = false;
    public $producto,$sucursal_id,$quantity,$qty=1,$sucursal,$pivot;

    protected $listeners = ['render' => 'render', 'actualizar' => 'actualizar'];

    public $search;

    protected $rules = [

        'sucursal_id' => 'required',
    ];

    public function mount()
    {

        $this->pivot = Pivot::where('id',$this->producto)->first();
        $this->sucursal = $this->pivot->sucursal_id;

        $this->sucursales = Sucursal::where('id', '!=', $this->sucursal )->get();
        $this->quantity = $this->pivot->cantidad;
       
    }

    public function decrement(){
        $this->qty = $this->qty - 1;
    }

    public function increment(){
        $this->qty = $this->qty + 1;
    }

    
    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false; 

    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
       /* $pivot = Pivot::where('id',$this->producto)->first();
        $this->sucursales = Sucursal::where('id', '!=', $pivot->sucursal_id)->get();
        $this->quantity = $pivot->cantidad;*/
        
        return view('livewire.productos.productos-traslado-seleccion');
    }

    
    public function addItem(){

        $rules = $this->rules;
        $this->validate($rules);

        $fecha_actual = date('Y-m-d');

        $user_auth_nombre =  auth()->user()->name;
        $user_auth_apellido =  auth()->user()->apellido;
        $sucursal_inicial = Sucursal::where('id', $this->sucursal)->first()->nombre;
        $sucursal_final = Sucursal::where('id', $this->sucursal_id)->first()->nombre;

        $producto_add = ProductosTraslado::where('producto_id',$this->pivot->producto_id)
            ->where('sucursal_origen',$this->sucursal)
            ->where('sucursal_id',$this->sucursal_id)
            ->where('lote',$this->pivot->lote)
            ->first();

        

        $product = Producto::where('id',$this->pivot->producto_id)->first();
        $product->update([
            'cantidad' => $product->cantidad - $this->qty,
        ]);
        
        //si ya hay un traslado pendiente igual 
        if($producto_add){
            $producto_add->update([
                'cantidad' => $producto_add->cantidad + $this->qty,
            ]);

            $traslado_pendiente = Traslado::where('sucursal_origen',$this->sucursal)
                                            ->where('sucursal_id',$this->sucursal_id)
                                            ->where('producto_id',$this->pivot->producto_id)
                                            ->where('lote',$this->pivot->lote)
                                            ->first(); 

            $traslado_pendiente->update([
                        'cantidad_enviada' => $traslado_pendiente->cantidad_enviada + $this->qty,
            ]);

            $pivot_decrement = Pivot::where('sucursal_id', $this->sucursal)->where('producto_id', $this->pivot->producto_id)->first();
            $pivot_decrement->cantidad = $pivot_decrement->cantidad - $this->qty;
            $pivot_decrement->save();

        }
        else{
            $producto_traslado = new ProductosTraslado();
            $producto_traslado->sucursal_origen = $this->sucursal;
            $producto_traslado->sucursal_id = $this->sucursal_id;
            $producto_traslado->producto_id = $this->pivot->producto_id;
            $producto_traslado->cantidad = $this->qty;
            $producto_traslado->lote = $this->pivot->lote;
            $producto_traslado->save();

            $traslado_pendiente = new Traslado();
            $traslado_pendiente->fecha= $fecha_actual;
            $traslado_pendiente->observacion_inicial = 'Traslado desde almacen ' . $sucursal_inicial . ' hasta almacen ' . $sucursal_final . ', por usuario ' . $user_auth_nombre . ' ' . $user_auth_apellido . ' Fecha del registro del tradado: ' . $fecha_actual;
            $traslado_pendiente->observacion_final='SIN RECIBIR EN SUCURSAL DESTINO';
            $traslado_pendiente->estado = 'PENDIENTE';
            $traslado_pendiente->cantidad_enviada = $this->qty;
            $traslado_pendiente->cantidad_recibida = 0;
            $traslado_pendiente->producto_id = $this->pivot->producto_id;
            $traslado_pendiente->lote = $this->pivot->lote;
            $traslado_pendiente->sucursal_origen = $this->sucursal;
            $traslado_pendiente->sucursal_id = $this->sucursal_id;
            $traslado_pendiente->save();

            $pivot_decrement = Pivot::where('sucursal_id', $this->sucursal)
                ->where('producto_id', $this->pivot->producto_id)
                ->where('lote',$this->pivot->lote)
                ->first();
                
            $pivot_decrement->cantidad = $pivot_decrement->cantidad - $this->qty;
            $pivot_decrement->save();
        }
        
    $this->reset('sucursal_id','qty','quantity');
    $this->isopen = false;
    $this->emitTo('productos.productos-detalle-traslado','render');
    $this->emitTo('productos.productos-traslado-pendientes','render');

    }
}
