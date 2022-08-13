<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Livewire\Admin\Categorias\CategoriaImport;
use App\Imports\CategoriasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CategoriasController extends Controller
{
    
    public function index()
    {
        return view('admin.categorias.index');
    }

    public function store(Request $request)
    {

        $request->validate([
            'import_file' => 'required'
        ]);
     
        $file = $request->file('import_file');
   
        Excel::import(new CategoriasImport(), $file);
        return redirect()->route('admin.categorias.index');
    }

}