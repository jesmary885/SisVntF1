<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\reniec\Reniec;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
   
    public function index()
    {
        return view('admin.clientes.index');
    }


}
