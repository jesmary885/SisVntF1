<div x-data="{buscador: @entangle('buscador')}">
    <div class="card">
        <div class="card-header flex items-center justify-between">
        <div class="flex-1">
                <div class="flex">
                    <div class="w-1/4">
                        <select title="Categoría de la busqueda" wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Por proveedor</option>
                                <option value="1">Por producto</option>
                                <option value="2">Por fechas</option>
                            </select>
                        <x-input-error for="buscador" />
                    </div>
                    <div class="flex-1 mr-2" :class="{'hidden' : buscador != '0'}">
                        <input wire:model="search" placeholder="Ingrese el nombre o nro de documento del proveedor a buscar" class="form-control ml-2">
                    </div>
                    <div class="flex-1 mr-2" :class="{'hidden' : buscador != '1'}">
                        <input wire:model="search" placeholder="Ingrese el nombre o código de barra a buscar" class="form-control ml-2">
                    </div>
                    <div :class="{'hidden' : buscador != '2'}">
                        <div class="lg:flex justify-items-stretch w-full mt-2 ml-4">
                            <div>
                                <x-input.date wire:model.lazy="fecha_inicio" id="fecha_inicio" placeholder="Seleccione la fecha inicio" class="px-4 outline-none"/>
                                <x-input-error for="fecha_inicio"/>     
                            </div>
                            <p class="ml-2 mr-2 text-gray-700 font-semibold">-</p>
                            <div>
                                <x-input.date wire:model.lazy="fecha_fin" id="fecha_fin" placeholder="Seleccione la fecha fin" class="px-4 outline-none"/>
                                <x-input-error for="fecha_fin"/>
                            </div>
                        </div>
                    </div>
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
        @if ($compras != '0' && $compras->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Precio de compra</th>
                            <th class="text-center">Deuda</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Sucursal</th>
                            <th colspan="1"></th>  
                   
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($compras as $compra)
                            <tr>
                                <td class="text-center">{{$compra->fecha}}</td>
                                <td class="text-center">{{$compra->producto->nombre}} - Cod. barra: {{$compra->producto->cod_barra}} - Lote: {{$compra->lote}}</td>
                                <td class="text-center">{{$compra->cantidad}}</td>
                                <td class="text-center">{{$compra->precio_compra}}</td>
                                <td class="text-center">{{$compra->deuda_a_proveedor}}</td>
                                <td class="text-center">{{$compra->total}}</td>
                                <td class="text-center">{{$compra->sucursal->nombre}}</td>
                                <td width="10px">
                                    @if ($compra->deuda_a_proveedor > 0)
                                     @livewire('admin.compras.compras-edit',['compra' => $compra],key($compra->id))
                                     @endif
                                     
                                </td>
                                {{-- <td width="10px">
                                    <button
                                        title="Eliminar compra"
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$compra->id}}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{$compras->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>