<div>
    <div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1 mr-2">
                    <input wire:model="search" placeholder="Ingrese el código de barra del producto" class="form-control">
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
