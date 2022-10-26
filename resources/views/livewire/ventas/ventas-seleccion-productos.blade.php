<div>
    <div>
        <div class="card overflow-y-auto">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex">
                        <div class="w-1/4">
                            <select wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Código de barra</option>
                                <option value="1">Nombre</option>
                                <option value="2">Marca</option>
                                <option value="3">Categoria</option>
                                <option value="4">Modelo</option>
                            </select>
                            <x-input-error for="buscador" />
                        </div>
                        <input autofocus wire:model="search" placeholder="Ingrese el producto a buscar" class="form-control ml-2">
                            
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
            @if ($productos)
                <div class="card-body">
                    @foreach ($productos as $producto)
                        <div class="flex justify-between">
                            <div>
                                <h4 class="text-gray-600 font-semibold">
                                {{$producto->nombre}} {{$producto->categoria->nombre}} {{$producto->modelo->nombre}} / {{$producto->marca->nombre}}
                                </h4>
                            </div>

                            <div>
                                @foreach ($producto->producto_lotes as $producto_lote)
                                    <div class="flex">
                                        <p class=" mt-2 text-md text-gray-800 font-semibold">Lote Nro. {{$producto_lote->lote}}</p>
                                            <div>
                                                @livewire('ventas.ventas-seleccion-cantidades', ['producto' => $producto_lote,'sucursal' => $sucursal, 'usuario' => $usuario],key($producto_lote->id))
                                            </div>    
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>

                <div class="card-footer">
                    {{$productos->links()}}
                </div>

            @else
                <div class="card-body">
                                   
                </div>
            @endif
        </div>

    </div>

    <div class="card">
        @livewire('ventas.ventas-cart', ['sucursal' => $sucursal,'proforma' => $proforma, 'caja' => $caja])
    </div>
</div>
