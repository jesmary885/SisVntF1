<?php

namespace App\Http\Livewire\Admin\Compras;

use App\Http\Livewire\Compras\ComprasIndex;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Producto_sucursal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
Use Livewire\WithPagination;

class CompraIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$compra;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {

        $compras = Compra::where('fecha', 'LIKE', '%' . $this->search . '%')
                                ->orwhereHas('producto',function(Builder $query){
                                    $query->where('nombre','LIKE', '%' . $this->search . '%');
                                })
                                ->latest('id')
                                ->paginate(5);

        return view('livewire.admin.compras.compra-index',compact('compras'));
    }

    public function delete($compraId){
        $this->compra = $compraId;
       // $busqueda = Compra::where('proveedor_id',$proveedorId)->first();

        //if($busqueda) $this->emit('errorSize', 'Este proveedor esta asociado a una compra, no puede eliminarlo');
        $this->emit('confirm', 'Esta seguro de eliminar esta comprar?','admin.compras.compra-index','confirmacion','La compra se ha eliminado.');
    }
    public function confirmacion(){
        $this->fecha_actual = date('Y-m-d');
        $usuario_auth = Auth::id();
        $compra_destroy = Compra::where('id',$this->compra)->first();
        $compra_destroy->delete();

        $producto_compra_destroy = Producto_sucursal::where('producto_id',$compra_destroy->producto_id)
                                                    ->where('sucursal_id',$compra_destroy->sucursal_id)->first();

        $cant_new_producto_compra =  $producto_compra_destroy - $compra_destroy->cantidad;
        $producto_compra_destroy->update([
            'cantidad' => $cant_new_producto_compra
        ]);

        $this->producto->movimientos()->create([
            'fecha' => $this->fecha_actual,
            'tipo_movimiento' => 'Eliminación de compra',
            'cantidad' => $compra_destroy->cantidad,
            'precio' => $compra_destroy->precio_compra,
            'observacion' => 'Se ha eliminado la compra',
            'user_id' => $usuario_auth
        ]);
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Editar compras: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada compra y complete el formulario.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Eliminar compra: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada compra, confirme haciendo click en la opción " Si, seguro " .</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Registro de compras: Al registrar el producto recibido automáticamente se registra la compra, por ende para registrar compras debe registrar el producto o agregar unidades al producto comprado.</p>');
    }

}
