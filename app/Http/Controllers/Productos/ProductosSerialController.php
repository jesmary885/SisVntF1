<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Imports\ProductosImport;
use App\Imports\ProductosSerialSucursalImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ProductosSerialController extends Controller
{
    public function index()
    {
        $vista = 'productos_serial';
        $proforma= 'productos_seria';
        $usuario_auth = User::where('id',Auth::id())->first();
        $sucursal = $usuario_auth->sucursal_id;

        if($usuario_auth->limitacion == '1')  return view('ventas.seleccion_sucursal',compact('vista','proforma'));
        else  return view('productos.serial_view',compact('sucursal'));

    }

    public function view($sucursal)
    {
        return view('productos.serial_view',compact('sucursal'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'import_file' => 'required'
        ]);
     
     
        $file = $request->file('import_file');
   
        Excel::import(new ProductosSerialSucursalImport(), $file);
        return redirect()->route('productos.serial.index');
    }


}
