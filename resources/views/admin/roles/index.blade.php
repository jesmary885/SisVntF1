@extends('adminlte::page')

@section('title', 'TechPeru')

@section('content_header')

<div class="flex">
    <div class="flex-1">
        <h1 class="text-lg ml-2"><i class="fas fa-th-list"></i> Listado de roles</h1>
       
    </div>
    <div class="mr-2">
        <a id="ayuda" class="btn btn-success btn-sm float-right"><i class="fas fa-info"></i> Ayuda rápida</a> 

    </div>
    
    <div>
         <a href="{{route('admin.roles.create')}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-shield-alt"></i> Nuevo rol</a> 
    </div>

</div>
    

@stop

@section('content')
@if (session('info'))
<div class="alert alert-success">
    {{session('info')}}
</div>
@endif
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th colspan="2"></th>     
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td width="10px">
                             <a href="{{route('admin.roles.edit', $role)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        </td>
                        <td width="10px">
                             <form action="{{route('admin.roles.destroy', $role)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                            </form> 
                        </td>
                    </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> 
     $('#ayuda').click(function(){ 
         Swal.fire({
             title: `<p class="text-sm m-0 p-0 text-gray-500 text-justify">1-. Registro de roles: Haga click en el botón " <i class="fas fa-shield-alt"></i> Nuevo rol " y complete el formulario, en el proximo formulario seleccione los permisos que tendrá el rol creado.</p>
             <p class="text-sm text-gray-500 m-0 p-0 text-justify">2-. Editar nombre y permisos del rol: Haga click en el botón " <i class="fas fa-edit"></i> ", ubicado al lado de cada rol y complete el formulario.</p> 
             <p class="text-sm text-gray-500 m-0 p-0 text-justify">3-.Eliminar rol: Haga click en el botón " <i class="fas fa-trash-alt"></i> ", ubicado al lado de cada rol, si el rol esta asociado a algún usuario no podrá eliminarlo, debe cambiar primero el rol de los usuarios que lo están utilizando y luego podrá eliminarlo.</p>`,
             showClass: {
             popup: 'animate__animated animate__fadeInDown'
             },
             hideClass: {
             popup: 'animate__animated animate__fadeOutUp'
             }
         })
     })
    </script>
@stop