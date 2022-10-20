<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Metodo_pago;
use App\Models\Producto_venta;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class VentasCredito extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $productos,$collection = [], $venta,$sucursal;


    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
    
        if($this->search){
            $ventas = Venta::where('fecha', 'LIKE', '%' . $this->search . '%')
                ->where('tipo_pago', 'Credito')
                ->where('sucursal_id',$this->sucursal)
                ->where('estado', 'activa')
                ->latest('id')
                ->paginate(10);
        }
        else{
            $ventas = Venta::orderBy('id', 'DESC')
                ->where('tipo_pago', 'Credito')
                ->where('sucursal_id',$this->sucursal)
                ->where('estado', 'activa')
                ->take(15)
                ->get();
        }

        return view('livewire.ventas.ventas-credito',compact('ventas'));
    }

    public function delete($ventaId){
        $this->venta = $ventaId;

        $this->emit('confirm', 'Esta seguro de anular esta venta?','ventas.ventas-credito','confirmacion','La venta se ha anulado.');
    }

    public function confirmacion(){
        $venta_destroy = Venta::where('id',$this->venta)->first();
        $venta_destroy->update([
            'estado' => 'anulada',
        ]);
        $this->resetPage();
    }

    public function ayuda(){
        $this->emit('ayuda','<p class="text-sm text-gray-500 m-0 p-0 text-justify">1-. Ver detalles de la venta: Haga click en el botón "<i class="fas fa-file-invoice"></i>", ubicado al lado de cada venta.</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Agregar pago de cliente: Haga click en el botón "<i class="fas fa-plus-square"></i>", ubicado al lado de cada venta, luego debe ingresar el monto abonado por el cliente y haga click en "Guardar".</p> 
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Anular venta: Haga click en el botón "<i class="fas fa-trash-alt"></i>" ubicado al lado de cada venta, la venta no se podrá restablecer, debe estar seguro de realizar esta acción.</p>');
    }


}
