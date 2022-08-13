<?php

namespace App\Http\Livewire\Admin\Marcas;

use App\Exports\PlanillaMarcasExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class MarcaImport extends Component
{
    public $isopen = false,$file;
    
    public function render()
    {
        return view('livewire.admin.marcas.marca-import');
    }
    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function planilla(){
        
        return Excel::download(new PlanillaMarcasExport(), 'Marcas.xlsx');

    }
}
