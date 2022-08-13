<div>
    <div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <input wire:model="search" placeholder="Ingrese el nombre o código de barra del equipo a buscar" class="form-control">
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
                                <th class="text-center">Código de Barra</th>
                                <th class="text-center">Descripción</th>
                                <th class="text-center">Stock</th>
                                <th colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
            
                                    <td class="text-center">{{$producto->cod_barra}}</td>
                                    <td class="text-center">{{$producto->nombre}}</td>
                                    <td class="text-center">{{$producto->sucursals->find($sucursal)->pivot->cantidad}}</td>                             
                                    <td width="10px">  
                                        <a href="{{route('productos.traslado.serial',['producto'=>$producto,'sucursal'=>$sucursal])}}" class="btn btn-primary btn-sm"><i class="fas fa-check"></i></a>
                                        {{-- @livewire('productos.productos-detalle-traslado', ['producto' => $producto, 'sucursal' => $sucursal],key($producto->id)) --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$productos->links()}}
                    <a href="{{route('traslado.index')}}" class="btn btn-primary mt-4"><i class="fas fa-undo-alt"></i> Regresar</a> 
                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
            @endif
                
        </div>
    </div>
</div>

