<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MetodosPagoController extends Controller
{
    public function index(){
        return view('admin.metodos.index');
    }
}
