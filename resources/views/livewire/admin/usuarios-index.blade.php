<div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <input wire:model="search" placeholder="Ingrese el nombre o correo del usuario a buscar" class="form-control">
                </div>

                <div class="ml-2">
                    <button
                    title="Ayuda a usuario"
                    class="btn btn-success btn-sm" 
                    wire:click="ayuda"><i class="fas fa-info"></i>
                    Guía rápida
                </button>
                </div>
                <div class="ml-2">
                    {{-- @livewire('admin.clientes.clientes-create',['vista' => 'clientes','accion' => 'create'])  --}}
                    <a href="{{route('admin.usuarios.create')}}" title="Registro de usuario" class="btn btn-primary btn-sm float-right"><i class="fas fa-user-plus"></i> Nuevo usuario</a>
                </div>
            </div>
            @if ($users->count())
                <div class="card-body">
                    <table class="table table-striped table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{$user->name}}</td>
                                    <td class="text-center">{{$user->email}}</td>
                                    <td class="text-center">{{$user->telefono}}</td>
                                    <td class="text-center">{{$user->roles->first()->name}}</td>
                                    <?php
                                        if($user->estado == '1') $estado = 'Activa';
                                        else $estado= 'Inactiva';
                                    ?>
                                    <td class="text-center">{{$estado}}</td>
                                    <td width="10px">
                                        @livewire('admin.usuarios-edit', ['usuario' => $user],key($user->id))
                                        {{-- <a href="#" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$users->links()}}
                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
            @endif
                
        </div>
</div>

