<div>
    <div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                    <div class="flex">
                        <div class="w-1/4">
                   
                            <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Código de barra</option>
                                <option value="1">Categoria</option>
                                <option value="2">Marca</option>
                                <option value="3">Presentación</option>
                                <option value="4">Nombre</option>
                            </select>
        
                            <x-input-error for="buscador" />
    
                        </div>
                        <input wire:model="search" placeholder="Ingrese el producto a buscar" class="form-control ml-2">
                            
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
            @if ($lotes != '0')
                <div class="card-body">
                    <table class="table table-bordered table-responsive-lg table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                               
                                <th class="text-center">Lote</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Precio compra</th>
                                <th class="text-center">Precio unitario</th>
                                <th class="text-center">Precio mayor</th>
                                <th class="text-center">Precio por combo</th>
                                <th class="text-center">Estado</th>
                               
                           
                                <th colspan="4"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotes as $lote)
                        
                                <tr >
                                    
                                    <td class="text-center">{{$lote->lote}}</td>
                                    <td class="text-center">{{$lote->producto->nombre}}</td>
                                    <td class="text-justify">{{$lote->stock}}</td>
                                    <td class="text-justify">{{round(($lote->precio_entrada / $tasa_dia),2)}} {{$moneda_simbolo}}</td>
                                    <td class="text-justify">{{round(($lote->precio_letal / $tasa_dia),2)}} {{$moneda_simbolo}}</td>
                                    <td class="text-justify">{{round(($lote->precio_mayor / $tasa_dia),2)}} {{$moneda_simbolo}}</td>
                                    <td class="text-justify">{{round(($lote->precio_combo / $tasa_dia),2)}} {{$moneda_simbolo}}</td>
                                    <td class="text-justify">{{$lote->status}}</td>
                                    
                                    <td width="10px">
                                         @livewire('productos.productos-lote-edit', ['lote' => $lote],key(01.,'$lote->id'))
                                    </td>
                                   
                                   @can('productos.lotes.delete')
                                    <td width="10px">
                                        <button
                                            class="btn btn-danger btn-sm" 
                                            wire:click="delete('{{$lote->id}}')"
                                            title="Eliminar lote">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$lotes->links()}}
                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
            @endif
                
        </div>
    </div>

</div>
