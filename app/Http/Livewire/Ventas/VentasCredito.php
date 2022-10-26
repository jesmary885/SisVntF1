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

    public $search,$buscador=0,$fecha_inicio,$fecha_fin;

    public function updatingSearch(){
        $this->resetPage();
    }

    public function render()
    {
    
        if($this->search || $this->fecha_fin){
            if($this->buscador == 0){
                $ventas = Venta::whereHas('cliente',function(Builder $query){
                    $query
                        ->where('nro_documento','LIKE', '%' . $this->search . '%')
                        ->orwhere('nombre','LIKE', '%' . $this->search . '%')
                        ->orwhere('apellido','LIKE', '%' . $this->search . '%');
                 })->latest('id')
                    ->where('estado', 'activa')
                    ->where('sucursal_id',$this->sucursal)
                    ->where('tipo_pago', 'Credito')
                    ->paginate(10);
            }

            else{
                $fecha_inicio = date("Y-m-d", strtotime($this->fecha_inicio));
                $fecha_fin = date("Y-m-d", strtotime($this->fecha_fin));

                $ventas = Venta::whereBetween('fecha',[$fecha_inicio,$fecha_fin])
                    ->where('estado', 'activa')
                    ->where('tipo_pago', 'Credito')
                    ->where('sucursal_id',$this->sucursal)
                    ->latest('id')
                    ->paginate(10);
            }
        }
        else{
            $ventas = 0;
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
