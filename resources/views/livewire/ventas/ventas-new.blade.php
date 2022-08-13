<div>
    <div>
        <div class="card">
            <div class="card-header">
                <input wire:model="search" placeholder="Ingrese el nombre o Cod. de barra del producto a buscar" class="form-control">
            </div>
            @if ($productos->count())
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Codigo de Barra</th>
                                <th class="text-center">Descripcion</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="text-center">{{$producto->cod_barra}}</td>
                                    <td class="text-center">{{$producto->nombre}}</td>
                                    <td class="text-center">@foreach ($sucursales as $sucursal)
                                        {{$sucursal->nombre}} = {{$producto->sucursals->find($sucursal)->pivot->cantidad}} <br>
                                        @endforeach</td>
                                    <td class="text-center">{{$producto->precio_letal}}</td>
                                   
                                    {{-- <td width="10px">
                                        @livewire('productos.productos-add', ['producto' => $producto],key($producto->id))
        
                                    </td> --}}
                                    <td width="10px">
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-check"></i></a>
                                    </td>
                                   
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$productos->links()}}
                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
            @endif
                
        </div>
    </div>
</div>