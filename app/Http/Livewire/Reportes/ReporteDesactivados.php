<?php

namespace App\Http\Livewire\Reportes;

use App\Models\ProductoSerialSucursal;
use App\Models\ProductosTraslado;
use App\Models\Traslado;
use Livewire\Component;
use App\Models\Producto_sucursal as Pivot;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class ReporteDesactivados extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$producto,$observaciones,$buscador;

    protected $rules = [

        'observaciones' => 'required',
    ];


    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        if($this->buscador == 0){
            $productos = ProductosTraslado::whereHas('productoSerialSucursal',function(Builder $query){
                $query->where('cod_barra','LIKE', '%' . $this->search . '%');
            })->paginate(5);

            $this->item_buscar = "el código de barra del producto a buscar ";
        }

        else{
            $productos = ProductosTraslado::whereHas('productoSerialSucursal',function(Builder $query){
                $query->where('serial','LIKE', '%' . $this->search . '%');
            })->paginate(5);

            $this->item_buscar = "el serial del producto a buscar ";
        }

        return view('livewire.reportes.reporte-desactivados',compact('productos'));
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Seleccionar equipo por código de barra a trasladar: Haga click en el botón "<i class="fas fa-check"></i>", ubicado al lado de cada equipo.</p>');
    }

    public function regresar($productoId){

        $rules = $this->rules;
        $this->validate($rules);


        $producto_selec = ProductosTraslado::where('id',$productoId)->first();
        $this->producto = $producto_selec->producto_serial_sucursal_id;

        $producto_sucursal = ProductoSerialSucursal::where('id',$this->producto)->first();
        
       
        $this->emit('confirm', 'Esta seguro de regresar este producto a inventario de la sucursal '.$producto_sucursal->sucursal->nombre.' ?','reportes.reporte-desactivados','confirmacion','Se ha reintegrado el producto a inventario.');
    }

    public function confirmacion(){
      
        $fecha_actual = date('Y-m-d');
        $user_auth =  auth()->user()->id;
        $user_auth_nombre =  auth()->user()->name;
        $user_auth_apellido =  auth()->user()->apellido;


        $producto_sucursal = ProductoSerialSucursal::where('id',$this->producto)->first();
        

        //eliminar traslado de ese producto en tabla productos_traslados

     

        $product_destroy = ProductosTraslado::where('producto_serial_sucursal_id',$this->producto)->first();
        $product_destroy->delete();

        //modificar en la tabla traslados que la sucursal destino es la misma de la inicial y guardar observacion final

        $traslado = Traslado::where('producto_serial_sucursal_id',$producto_sucursal->id)
        ->where('estado','PENDIENTE')
        ->first();

        $traslado->update([
            'observacion_final' => $this->observaciones .', usuario que registra la operación '. $user_auth_nombre .' '. $user_auth_apellido. ' Fecha del registro: '. $fecha_actual,
            'estado' => 'RECIBIDO'
        ]);


        //activar producto en producto_serial_sucursals

        $producto_sucursal->update([
            'estado' => 'activo',
        ]);

        //incrementar a uno la tabla pivote

        $pivot_increment = Pivot::where('sucursal_id',$producto_sucursal->sucursal_id)->where('producto_id',$producto_sucursal->producto_id)->first(); 
        $pivot_increment->cantidad = $pivot_increment->cantidad + 1;
        $pivot_increment->save();

    }

}
