<div>
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese el nombre de la caja a buscar" class="form-control">
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
                @livewire('admin.cajas.caja-create',['accion' => 'create'])
            </div>
        </div>

        @if ($cajas->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
           
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Sucursal</th>
                            <th class="text-center">Saldo</th>
                            <th class="text-center">Status</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cajas as $caja)
                            <tr>
                            
                                <td class="text-center">{{$caja->nombre}}</td>
                                <td class="text-center">{{$caja->sucursal->nombre}}</td>
                                <td class="text-center">{{$caja->saldo}}</td>
                                <td class="text-center">{{$caja->status}}</td>
                                <td width="10px">
                                    @livewire('admin.cajas.caja-create',['accion' => 'edit', 'caja' => $caja->id],key($caja->id))
                                </td>
                                <td width="10px">
                                    <button
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$caja->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$cajas->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>
