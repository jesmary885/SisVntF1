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
                        <input autofocus wire:model="search" placeholder="Ingrese {{$item_buscar}}" class="form-control ml-2">
                            
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
                    <div class="flex justify-between">
                        <div>
                            <h4 class="text-gray-600 font-semibold">
                            {{$productos->nombre}} {{$productos->categoria->nombre}} {{$productos->modelo->nombre}} / {{$productos->marca->nombre}}
                            </h4>
                        </div>

                        <div>
                            @if ($producto_lotes != '0')
                                @foreach ($producto_lotes as $producto_lote)
                                <div class="flex">
                                    <p class=" mt-2 text-md text-gray-800 font-semibold">Lote Nro. {{$producto_lote->lote}}</p>
                                    <div>
                                        @livewire('ventas.ventas-seleccion-cantidades', ['producto' => $producto_lote,'sucursal' => $sucursal, 'usuario' => $usuario],key($producto_lote->id))
                                    </div>    
                                </div>
                               
                                @endforeach
                            @endif
                        </div>
                    </div>
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
