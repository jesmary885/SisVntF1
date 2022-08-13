<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PlanillaModelosExport implements FromView
{
  
    public function view(): View
    {

       
        return view('planillas.modelos');
    }
}
