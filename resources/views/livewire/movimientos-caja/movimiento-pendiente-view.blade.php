<div>

    <div class="card">
        <div class="card-header flex items-center justify-between">
            
            <div class="ml-2">
                <button
                title="Ayuda a usuario"
                class="btn btn-success btn-sm" 
                wire:click="ayuda"><i class="fas fa-info"></i>
                Guía rápida
                </button>
            </div>
        </div>
        @if ($movimientos->count())
            <div class="card-body">
                <table class="table table-bordered ">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center">Fecha y hora</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Usuario</th>
                            <th colspan="1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <tr>
                                <td class="text-center">{{$movimiento->fecha}}</td>
                                <td class="text-center">{{$movimiento->cantidad}}</td>
                                <td class="text-center">Transferencia emitida por usuario {{$movimiento->user->nombre}} {{$movimiento->user->apellido}}</td>
                                <td class="text-center">{{$movimiento->user->name}} {{$movimiento->user->apellido}}</td>
                                <td width="10px">
                                    <button
                                        class="btn btn-success btn-sm" 
                                        wire:click="recibir('{{$movimiento->id}}')"
                                        title="Recibir movimiento">
                                        <i class="fas fa-hand-holding-usd"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
               
            </div>
            <div class="card-footer">
                {{$movimientos->links()}}
            </div>
        @else
             <div class="card-body">
                <strong>No hay registros</strong>
            </div>
        @endif
            
    </div>
</div>
