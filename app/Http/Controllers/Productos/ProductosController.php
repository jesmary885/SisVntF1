<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Imports\ProductosImport;
use App\Models\Producto;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductosController extends Controller
{  
    public function index()
    {
        return view('productos.index');
    }
    public function create()
    {
        return view('productos.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'import_file' => 'required'
        ]);
     
        
        $file = $request->file('import_file');
        Excel::import(new ProductosImport(), $file);
        return redirect()->route('productos.productos.index');
    }
    public function show($id)
    {
        //
    }
    public function edit(Producto $producto)
    {
        return view('productos.serial',compact('producto'));
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
