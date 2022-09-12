<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class tasaController extends Controller
{
    public function index()
    {
        return view('admin.tasa.index');
    }
}
