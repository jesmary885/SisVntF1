<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ModelosImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ModelosController extends Controller
{
    
    public function index()
    {
        return view('admin.modelos.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);
     
     
        $file = $request->file('import_file');
   
        Excel::import(new ModelosImport(), $file);
        return redirect()->route('admin.modelos.index');
    }
   
}
