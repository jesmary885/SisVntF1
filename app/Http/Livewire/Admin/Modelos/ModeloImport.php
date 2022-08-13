<?php

namespace App\Http\Livewire\Admin\Modelos;

use App\Exports\PlanillaModelosExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ModeloImport extends Component
{
    public $isopen = false,$file;
    
    public function render()
    {
        return view('livewire.admin.modelos.modelo-import');
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
        
        return Excel::download(new PlanillaModelosExport(), 'Modelos.xlsx');

    }

}
