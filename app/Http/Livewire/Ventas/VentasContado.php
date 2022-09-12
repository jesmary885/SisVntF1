<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Sucursal;
use App\Models\Venta;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class VentasContado extends Component
{

    use WithPagination;
    protected $paginationTheme = "bootstrap";


    protected $listeners = ['render' => 'render','confirmacion' => 'confirmacion'];

    public $search,$sucursal;

    public function updatingSearch(){
        $this->resetPage();
    }

  

   
    public function render()
    {

        $ventas = Venta::where('fecha', 'LIKE', '%' . $this->search . '%')
                    ->where('tipo_pago', 'Contado')
                    ->where('sucursal_id',$this->sucursal)
                    ->where('estado', 'activa')
                    ->latest('id')
                    ->paginate(5);


        return view('livewire.ventas.ventas-contado',compact('ventas'));
    }

    public function delete($ventaId){
        $this->venta = $ventaId;

        $this->emit('confirm', 'Esta seguro de anular esta venta?','ventas.ventas-contado','confirmacion','La venta se ha anulado.');
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
        <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-.Anular venta: Haga click en el botón "<i class="fas fa-trash-alt"></i>" ubicado al lado de cada venta, la venta no se podrá restablecer, debe estar seguro de realizar esta acción.</p>');
    }

   
}
