<?php

namespace App\Http\Livewire\Admin\Categorias;

use App\Exports\PlanillaCategoriasExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CategoriaImport extends Component
{
    public $isopen = false,$file;

   
    
    public function render()
    {
        return view('livewire.admin.categorias.categoria-import');
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
        
        return Excel::download(new PlanillaCategoriasExport(), 'Categorias.xlsx');

    }
}
