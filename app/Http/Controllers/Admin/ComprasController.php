<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ComprasImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ComprasController extends Controller
{
    public function index()
    {
        return view('admin.compras.index');
    }

    public function store(Request $request)
    {

        $request->validate([
            'import_file' => 'required'
        ]);
     
        $file = $request->file('import_file');
   
        Excel::import(new ComprasImport(), $file);
        return redirect()->route('admin.compras.index');
    }

}
