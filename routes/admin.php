<?php



use App\Http\Controllers\Admin\UsuarioController;


use Illuminate\Support\Facades\Route;


Route::resource('usuarios', UsuarioController::class)->only('index','create')->names('admin.usuarios')->middleware('permission:admin.usuarios.index');


