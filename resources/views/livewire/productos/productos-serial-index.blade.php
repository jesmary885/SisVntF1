<div>
    <div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <div class=flex>
                        <div class="w-1/4">
                   
                            <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Modelo</option>
                                <option value="1">Categoria</option>
                                <option value="2">Marca</option>
                                <option value="3">Código de barra</option>
                                <option value="4">Serial</option>
                            </select>
        
                            <x-input-error for="buscador" />
    
                        </div>
                        <input wire:model="search" placeholder="Ingrese {{$item_buscar}}" class="form-control ml-2">
                            
                    </div>
                    
                </div>
                <div class="ml-2">
                    <button
                        title="Ayuda a usuario"
                        class="btn btn-success btn-sm" 
                        wire:click="ayuda"><i class="fas fa-info"></i>
                        Guía rápida
                    </button>
                </div>
            </div>
            @if ($productos->count())
                <div class="card-body">
                    <table class="table table-bordered table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Fecha de compra
                                <th class="text-center">Compra Nro</th>
                                <th class="text-center">Prod/Cat</th>
                                <th class="text-center">Marc/Mod</th>
                                <th class="text-center">Código de Barra</th>
                                <th class="text-center">Serial</th>
                                <th colspan="2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="text-center">{{$producto->fecha_compra}}</td>
                                    <td class="text-center">{{$producto->compra_id}}</td>
                                    <td class="text-center">{{$producto->producto->nombre}}/{{$producto->categoria->nombre}} </td>
                                    <td class="text-center">{{$producto->marca->nombre}}/{{$producto->modelo->nombre}}</td>
                                    <td class="text-center">{{$producto->producto->cod_barra}}</td>
                                    <td class="text-center">{{$producto->serial}}</td>

                                    <td width="10px">
                                        @livewire('productos.productos-add-serial', ['producto' => $producto],key($producto->id))
                                    </td>
                                    <td width="10px">
                                        @can('productos.productos.delete')
                                        <button
                                            class="btn btn-danger btn-sm" 
                                            wire:click="delete('{{$producto->id}}')"
                                            title="Eliminar producto">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endcan
                                    </td>
                            
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer flex">
                    <div class="flex -1">
                        
                        {{$productos->links()}}
                    </div>

                    <div class="ml-2 mr-2">
                        <a href="{{route('productos.serial.index')}}" class="btn btn-primary ml-4"><i class="fas fa-undo-alt"></i> Regresar</a>
                    </div>
                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                    <div>
                        <a href="{{route('productos.serial.index')}}" class="btn btn-primary mt-4 ml-2"><i class="fas fa-undo-alt"></i> Regresar</a>
                    </div>
                </div>
               
            @endif
                
        </div>
    </div>

</div>
