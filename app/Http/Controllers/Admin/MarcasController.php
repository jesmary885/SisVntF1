<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Admin\Marcas\MarcaImport;
use App\Imports\MarcasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MarcasController extends Controller
{
   
    public function index()
    {
        return view('admin.marcas.index');
    }
    public function store(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
     
        
        $file = $request->file('import_file');
   
        Excel::import(new MarcasImport(), $file);
        return redirect()->route('admin.marcas.index');
    }

}
