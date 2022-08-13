<?php

namespace App\Http\Livewire\Productos;

use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Livewire\Component;
use PDF;

class ProductosBarcode extends Component
{

    public $isopen = false;
    public $producto, $cantidad;

    protected $rules = [
        'cantidad' => 'required',
    ];

    public function render()
    {
        return view('livewire.productos.productos-barcode');
    }

    
    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function print(){

        $rules = $this->rules;
        $this->validate($rules);

        if($this->cantidad < 0){
            $this->emit('errorSize','Ha ingresado un valor negativo, intentelo de nuevo');
        }else{
            $data = [
                'cod_barra' => $this->producto->cod_barra,
                'nombre' => $this->producto->nombre,
                'cantidad' => $this->cantidad,     
            ];
    
            $pdf = PDF::loadView('productos.barcode',$data)->output();
    
            return response()->streamDownload(
                fn () => print($pdf),
               "filename.pdf"
                );
        }

       


    }
}
