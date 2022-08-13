<div>
    <div class="card">
      
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese el nombre o nro de documento del proveedor" class="form-control">
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
                @livewire('admin.proveedores.proveedor-create',['accion' => 'create'])
            </div>

        </div>
        @if ($proveedores->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Proveedor</th>
                            <th class="text-center">Encargado</th>
                            <th class="text-center">Teléfono</th>
                            <th class="text-center">Email</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proveedores as $proveedor)
                            <tr>
                                <td class="text-center">{{$proveedor->nombre_proveedor}}</td>
                                <td class="text-center">{{$proveedor->nombre_encargado}}</td>
                                <td class="text-center">{{$proveedor->telefono}}</td>
                                <td class="text-center">{{$proveedor->email}}</td>
                                <td width="10px">
                                    @livewire('admin.proveedores.proveedor-create',['accion' => 'edit', 'proveedor' => $proveedor->id],key($proveedor->id))
                                </td>
                                <td width="10px">
                                    <button
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$proveedor->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$proveedores->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>


