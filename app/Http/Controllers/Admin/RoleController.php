<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index',compact('roles'));
    }

   
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role = Role::create($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.edit',$role)->with('info','El rol se creo con éxito');
    }

    
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

   
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $role->update($request->all());
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index')->with('info','Se han registrado los datos con éxito');
    }

  
    public function destroy(Role $role)
    {

        $usuarios = User::all();
        $cont = 0;

        foreach($usuarios as $usuario){
           if($usuario->roles->first()->id == $role->id) $cont++;
        }

        if($cont != 0){
            return redirect()->route('admin.roles.index')->with('info','El rol esta asociado a algún usuario, no puedo eliminarlo');
        }else
        {
            $role->delete();
            return redirect()->route('admin.roles.index')->with('info','El rol se ha eliminado con éxito');
        }
       
    }
}
