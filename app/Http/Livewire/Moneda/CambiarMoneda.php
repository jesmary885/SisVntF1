<?php

namespace App\Http\Livewire\Moneda;

use App\Models\Moneda;
use App\Models\tasa_dia;
use Livewire\Component;
use Livewire\WithPagination as LivewireWithPagination;

class CambiarMoneda extends Component
{

    use LivewireWithPagination;

    public $monedas, $moneda_new, $moneda_id;
    public $isopen = false;

    protected $listeners = ['render'];

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function mount(){

       // $this->isopen = true;

        if (session()->has('moneda')) $moneda_actual = session('moneda');
        else  $moneda_actual = "Bolivar";

        $this->moneda_id = Moneda::where('nombre',$moneda_actual)
            ->first()->id;
        
        $this->monedas=Moneda::where('id', '!=', $this->moneda_id)->get();

    }
    public function render()
    {
        return view('livewire.moneda.cambiar-moneda');
    }

    public function cambiar_moneda($moneda_select){

        $this->moneda_new = Moneda::where('id',$moneda_select)
        ->first();

        session(['moneda' => $this->moneda_new->nombre]);

        session(['simbolo_moneda' => $this->moneda_new->simbolo]);

        return redirect(request()->header('Referer'));
    }

}
