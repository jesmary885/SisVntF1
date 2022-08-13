<div>
    <div class="card">

        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese el nombre de la categoria a buscar" class="form-control">
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
                @livewire('admin.categorias.categoria-create',['accion' => 'create'])
            </div>
        </div>


        @if ($categorias->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                  
                            <th class="text-center">Categoria</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categorias as $categoria)
                            <tr>
                               
                                <td class="text-center">{{$categoria->nombre}}</td>
                                <td width="10px">
                                    @livewire('admin.categorias.categoria-create',['accion' => 'edit', 'categoria' => $categoria->id],key($categoria->id))
                                </td>
                                <td width="10px">
                                    <button
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$categoria->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$categorias->links()}}
            </div>
        @else
        <div class="card-body">
            <strong>No hay registros</strong>
        </div>
        @endif
            
    </div>
</div>
