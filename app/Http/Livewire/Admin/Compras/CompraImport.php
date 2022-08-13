<?php

namespace App\Http\Livewire\Admin\Compras;

use App\Exports\PlanillaComprasExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CompraImport extends Component
{
    public $isopen = false,$file;

      
    public function open()
    {
        $this->isopen = true;  
    }
    public function close()
    {
        $this->isopen = false;  
    }

    public function render()
    {
        return view('livewire.admin.compras.compra-import');
    }

    public function planilla(){
        return Excel::download(new PlanillaComprasExport(), 'Compras.xlsx');
    }

}
