<div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex-1">
                    <input wire:model="search" placeholder="Ingrese la fecha de la devolución a buscar" class="form-control">
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
            @if ($devoluciones->count())
                <div class="card-body">
                    <table class="table table-bordered table-responsive-md table-responsive-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Producto devuelto</th>
                                <th class="text-center">Factura Nro</th>
                                <th class="text-center">Usuario</th>
                                <th class="text-center">Observaciones</th>
                                <th colspan="1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devoluciones as $devolucion)
                                <tr>
                                    <td class="text-center">{{$devolucion->fecha}}</td>
                                    <td class="text-center">{{$devolucion->producto->nombre}} {{$devolucion->producto->marca->nombre}} {{$devolucion->producto->modelo->nombre}}</td>
                                    <td class="text-center">{{$devolucion->venta->id}}</td>
                                    <td class="text-center">{{$devolucion->user->name}} {{$devolucion->user->apellido}}</td>
                                    <td class="text-center"><p>Cantidad devuelto:</p> {{$devolucion->cantidad}} {{$devolucion->observaciones}}</td>
                                    <td width="10px">
                                        <button title="Regresar equipo a inventario"
                                            class="btn btn-primary btn-sm" 
                                            wire:click="inventariar('{{$devolucion->producto_id}}','{{ $devolucion->id}}','{{$devolucion->venta->id}}')">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button> 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{$devoluciones->links()}}
                </div>
            @else
                 <div class="card-body">
                    <strong>No hay registros</strong>
                </div>
            @endif
                
        </div>

</div>

