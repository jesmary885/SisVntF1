<div>

    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese el nombre o nro de documento del cliente a buscar" class="form-control">
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
                <button
                title="Exportar clientes"
                class="btn btn-success btn-sm" 
                wire:click="export"><i class="far fa-file-excel"></i>
                Exportar clientes
            </button>
        </div>

            <div class="ml-2">
                @livewire('admin.clientes.clientes-create',['vista' => 'clientes','accion' => 'create']) 
            </div>

            
            

        </div>
        @if ($clientes->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-sm table-responsive-md ">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Nº de documento</th>
                            <th class="text-center">Teléfono</th>
                            <th colspan="2"></th>  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr>
                                <td class="text-center">{{$cliente->nombre}} {{$cliente->apellido}}</td>
                                <td class="text-center">{{$cliente->nro_documento}}</td>
                                <td class="text-center">{{$cliente->telefono}}</td>
                                <td width="10px">
                                    @livewire('admin.clientes.clientes-create',['vista' => 'clientes','accion' => 'edit', 'cliente' => $cliente->id],key($cliente->id))
                                </td>
                                <td width="10px">
                                    <button
                                        title="Eliminar cliente"
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$cliente->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$clientes->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>

