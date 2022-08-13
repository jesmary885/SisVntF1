<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Sucursal;
use Livewire\Component;

class VentasSeleccionSucursal extends Component
{
    public $vista,$proforma;

    public function render()
    {

        $proforma = $this->proforma;
        $sucursales = Sucursal::where('status','1')->get();

        return view('livewire.ventas.ventas-seleccion-sucursal',compact('sucursales','proforma'));
    }
}
