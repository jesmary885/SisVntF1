<?php

namespace App\Http\Livewire\Productos;

use App\Exports\PlanillaProductosExport;
use App\Exports\PlanillaProductosSerialExport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ProductosImport extends Component
{

    public $isopen = false,$file,$vista;
    use WithFileUploads;


    public function render()
    {
        return view('livewire.productos.productos-import');
    }

    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function import(){

        //Excel::import(new ProductosImport(), $this->file);
        
        //return redirect('/')->with('success', 'All good!');
        
    }


    public function planilla(){

        if($this->vista == 'barra') return Excel::download(new PlanillaProductosExport(), 'Productos.xlsx');
        else return Excel::download(new PlanillaProductosSerialExport(), 'Productos_por_serial.xlsx');
    }




}
