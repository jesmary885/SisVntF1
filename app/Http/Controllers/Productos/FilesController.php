<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function files(Producto $producto, Request $request){

        $request->validate([
            'file' => 'required|image|max:2048'
        ]);
        
        $url = Storage::put('public/productos', $request->file('file'));

        $producto->images()->create([
            'url' => $url
        ]);
    }
}

