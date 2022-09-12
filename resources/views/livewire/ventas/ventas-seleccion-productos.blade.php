<div>
    <div>
        <div class="card overflow-y-auto">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex">
                        <div class="w-1/4">
                            <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Código de barra</option>
                                <option value="1">Marca</option>
                                <option value="2">Categoria</option>
                                <option value="3">Modelo</option>
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
            @if ($productos != '0')
                <div class="card-body">
                    <table class="table table-bordered table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Producto/Categoria</th>
                                <th class="text-center">Modelo/Marca</th>
                                {{-- <th class="text-center">Stock</th> --}}
                                <th class="text-center">Unitario</th>
                                <th class="text-center">Mayor</th>
                                <th colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach ($productos as $producto)--}}
                                <tr>
                                   
                                     <td class="text-center">{{$productos->nombre}} / {{$productos->categoria->nombre}}   </td>
                                    <td class="text-center">{{$productos->modelo->nombre}} / {{$productos->marca->nombre}}</td> -->
                                    {{-- <td class="text-center">@livewire('productos.productos-stock-sucursal', ['producto' => $producto],key(0.,'$producto->id'))</td> --}}
                                    <td class="text-center">{{ $productos->precio_letal}}</td>
                                    <td class="text-center">{{ $productos->precio_mayor}}</td>
                                    <td width="10px">
                                     @livewire('ventas.ventas-seleccion-cantidades', ['producto' => $productos,'sucursal' => $sucursal, 'usuario' => $usuario],key($productos->id))
                                        <a href="#" class="btn btn-info btn-sm"><i class="fas fa-check"></i></a>
                                    </td>
                                </tr>
                                {{--@endforeach--}}
                        </tbody>
                    </table>
                </div>
                <div class="flex card-footer overflow-y-auto">
    
                    {{-- <div class="ml-2 flex justify-content-center">
                        <div>
                            <a href="{{route('ventas.ventas.index')}}" class="btn btn-primary">Regresar</a>
                           
                        </div>
                        <div class="ml-2">
                            <a href="{{route('facturacion',['sucursal'=>$sucursal ,'proforma'=>$proforma])}}" class="btn btn-primary">Continuar</a>
                        </div>
                      
                        
                    </div> --}}
    
                </div>
            @else
                <div class="card-body">
                    <!--<strong>No hay registros</strong>
                    <div class="mt-4">
                        <a href="{{route('ventas.ventas.index')}}" class="btn btn-primary"><< Regresar</a>
    
                    </div> -->
                    
                </div>
            @endif
    
        </div>

    </div>

    <div class="card">
        @livewire('ventas.ventas-cart', ['sucursal' => $sucursal,'proforma' => $proforma])
    </div>
</div>
