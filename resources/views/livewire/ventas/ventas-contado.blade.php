<div  x-data="{buscador: @entangle('buscador')}">
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <div class="flex">
                    <div class="w-1/4">
                        <select title="Categoría de la busqueda" wire:model="buscador" id="buscador" class="form-control text-m" name="buscador">
                                <option value="0">Por cliente</option>
                                <option value="1">Por fechas</option>
                            </select>
                        <x-input-error for="buscador" />
                    </div>
                    <div class="flex-1 mr-2" :class="{'hidden' : buscador == '1'}">
                        <input wire:model="search" placeholder="Ingrese el nombre o nro de documento del cliente a buscar" class="form-control ml-2">
                    </div>
                    <div :class="{'hidden' : buscador == '0'}">
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
        @if ($ventas != '0' && $ventas->count())
            <div class="card-body mt-0">
                <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Cliente - Documento</th>
                            <th class="text-center">Estado de entrega</th>
                            <th class="text-center">Total de venta</th>
                            <th colspan="2"></th>  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                          
                                <td class="text-center">{{  \Carbon\Carbon::parse($venta->fecha)->format('d-m-Y') }}</td>
                                <td class="text-center">{{$venta->cliente->nombre}} {{$venta->cliente->apellido}}</td>
                                <td class="text-center">{{$venta->cliente->nro_documento}}</td>
                                <td class="text-center">{{$venta->estado_entrega}}</td>
                                <td class="text-center">{{$venta->total}}</td>
                                <td width="10px">
                                    @livewire('ventas.ventas-view', ['venta' => $venta],key('0'.' '.$venta->id)) 
                                </td>
                                <td width="10px">
                                    <button
                                        class="btn btn-danger btn-sm" 
                                        wire:click="delete('{{$venta->id}}')"
                                        title="Anular venta">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
                <div class="card-footer">
                    {{$ventas->links()}}
                </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>