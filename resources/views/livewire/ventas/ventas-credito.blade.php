<div>
    <div class="card">
        <div class="card-header flex items-center justify-between">
            <div class="flex-1">
                <input wire:model="search" placeholder="Ingrese la fecha de la venta a buscar" class="form-control">
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
 
        @if ($ventas->count())
            <div class="card-body">
                <table class="table table-striped table-responsive-lg table-responsive-md table-responsive-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Cliente</th>
                            <th class="text-center">Cliente - Documento</th>
                            <th class="text-center">Estado de entrega</th>
                            <th class="text-center">Total de venta</th>
                            <th class="text-center">Total pagado</th>
                            <th class="text-center">Deuda</th>
                            <th colspan="3"></th>  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td class="text-center">{{$venta->fecha}}</td>
                                <td class="text-center">{{$venta->cliente->nombre}} {{$venta->cliente->apellido}}</td>
                                <td class="text-center">{{$venta->cliente->nro_documento}}</td>
                                <td class="text-center">{{$venta->estado_entrega}}</td>
                                <td class="text-center">{{$venta->total}}</td>
                                <td class="text-center">{{$venta->total_pagado_cliente}}</td>
                                <td class="text-center">{{$venta->deuda_cliente}}</td>
                                <td width="10px">
                                      @livewire('ventas.ventas-credito-abono', ['venta' => $venta,'vista' => '2'],key($venta->id)) 
                                     {{-- <a href="#" class="btn btn-info btn-sm"><i class="fas fa-plus-square"></i></a> --}}
                                </td>
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
