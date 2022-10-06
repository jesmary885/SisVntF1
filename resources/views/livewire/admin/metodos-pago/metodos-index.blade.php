<div>
    <div class="card">

        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese el nombre del método a buscar" class="form-control">
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
                @livewire('admin.metodos-pago.metodos-create',['accion' => 'create'])
            </div>
        </div>


        @if ($metodos->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                  
                            <th class="text-center">Método</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($metodos as $metodo)
                            <tr>
                               
                                <td class="text-center">{{$metodo->nombre}}</td>
                                <td width="10px">
                                    @livewire('admin.metodos-pago.metodos-create',['accion' => 'edit', 'metodo' => $metodo->id],key($metodo->id))
                                </td>
                                <td width="10px">
                                    <button
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$metodo->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$metodos->links()}}
            </div>
        @else
        <div class="card-body">
            <strong>No hay registros</strong>
        </div>
        @endif
            
    </div>
</div>
