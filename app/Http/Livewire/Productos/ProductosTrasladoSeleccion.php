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
    public $sucursal,$producto,$sucursal_id,$quantity,$qty=1;

    protected $listeners = ['render' => 'render', 'actualizar' => 'actualizar'];

    public $search;

    protected $rules = [

        'sucursal_id' => 'required',
    ];

    public function mount()
    {
    
        $this->sucursales = Sucursal::where('id', '!=', $this->sucursal)->get();

        $pivot = Pivot::where('sucursal_id',$this->sucursal)
                        ->where('producto_id',$this->producto->id)
                        ->first();
       // dd($this->sucursal);

        $this->quantity = $pivot->cantidad;
       
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
        $this->sucursales = Sucursal::where('id', '!=', $this->sucursal)->get();

        $pivot = Pivot::where('sucursal_id',$this->sucursal)
                        ->where('producto_id',$this->producto->id)
                        ->first();
       // dd($this->sucursal);

        $this->quantity = $pivot->cantidad;
        
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

        $producto_add = ProductosTraslado::where('producto_id',$this->producto->id)
                                            ->where('sucursal_origen',$this->sucursal)
                                            ->where('sucursal_id',$this->sucursal_id)
                                            ->first();

        $product = Producto::where('id',$this->producto->id)->first();
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
                                            ->where('producto_id',$this->producto->id)
                                            ->first(); 

            $traslado_pendiente->update([
                        'cantidad_enviada' => $traslado_pendiente->cantidad_enviada + $this->qty,
            ]);

            $pivot_decrement = Pivot::where('sucursal_id', $this->sucursal)->where('producto_id', $this->producto->id)->first();
            $pivot_decrement->cantidad = $pivot_decrement->cantidad - $this->qty;
            $pivot_decrement->save();

        }
        else{
            $producto_traslado = new ProductosTraslado();
            $producto_traslado->sucursal_origen = $this->sucursal;
            $producto_traslado->sucursal_id = $this->sucursal_id;
            $producto_traslado->producto_id = $this->producto->id;
            $producto_traslado->cantidad = $this->qty;
            $producto_traslado->save();

            $traslado_pendiente = new Traslado();
            $traslado_pendiente->fecha= $fecha_actual;
            $traslado_pendiente->observacion_inicial = 'Traslado desde almacen ' . $sucursal_inicial . ' hasta almacen ' . $sucursal_final . ', por usuario ' . $user_auth_nombre . ' ' . $user_auth_apellido . ' Fecha del registro del tradado: ' . $fecha_actual;
            $traslado_pendiente->observacion_final='SIN RECIBIR EN SUCURSAL DESTINO';
            $traslado_pendiente->estado = 'PENDIENTE';
            $traslado_pendiente->cantidad_enviada = $this->qty;
            $traslado_pendiente->cantidad_recibida = 0;
            $traslado_pendiente->producto_id = $this->producto->id;
            $traslado_pendiente->sucursal_origen = $this->sucursal;
            $traslado_pendiente->sucursal_id = $this->sucursal_id;
            $traslado_pendiente->save();

            $pivot_decrement = Pivot::where('sucursal_id', $this->sucursal)->where('producto_id', $this->producto->id)->first();
            $pivot_decrement->cantidad = $pivot_decrement->cantidad - $this->qty;
            $pivot_decrement->save();


        }
        
    $this->reset('sucursal_id','qty','quantity');
    $this->isopen = false;
    $this->emitTo('productos.productos-detalle-traslado','render');
    $this->emitTo('productos.productos-traslado-pendientes','render');

    }
}
